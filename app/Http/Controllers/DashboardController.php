<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isVendor()) {
            return $this->vendorDashboard();
        }

        if ($user->isClient()) {
            return $this->clientDashboard();
        }

        return redirect('/login');
    }

    private function adminDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_users' => User::count(),
            'total_vendors' => User::where('role', 'vendor')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_services' => Service::count(),
            'total_bookings' => Booking::count(),
            'pending_vendors' => Vendor::where('status', 'pending')->count(),
            'pending_users' => User::where('status', 'pending')->count(),
            'active_services' => Service::where('status', 'active')->count(),
            'total_visits' => Visit::count(),
        ];

        $allUsers = User::with('vendor')->latest()->get();
        $allVendors = Vendor::with('user', 'services')->latest()->get();
        $allServices = Service::with('vendor.user')->latest()->get();
        $allBookings = Booking::with(['user', 'items.service.vendor.user'])->latest()->get();

        return view('dashboards.admin', compact('user', 'stats', 'allUsers', 'allVendors', 'allServices', 'allBookings'))->with('header', 'Admin Dashboard - IntelliWed Platform');
    }

    private function vendorDashboard()
    {
        $user = Auth::user();
        $vendor = $user->vendor;

        if (!$vendor) {
            $vendor = Vendor::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        $services = $vendor->services()->withCount(['bookingItems', 'visits'])->latest()->get();
        
        // Fetch bookings that have items belonging to this vendor
        $bookings = Booking::whereHas('items', function($query) use ($services) {
            $query->whereIn('service_id', $services->pluck('id'));
        })->with(['user', 'items' => function($query) use ($services) {
            $query->whereIn('service_id', $services->pluck('id'))->with('service');
        }])->latest()->get();

        $vendorStats = [
            'total_services' => $services->count(),
            'total_bookings' => $services->sum('booking_items_count'),
            'total_views' => $services->sum('visits_count'),
            'active_services' => $services->where('status', 'active')->count(),
        ];

        return view('dashboards.vendor', compact('user', 'vendor', 'services', 'bookings', 'vendorStats'))->with('header', 'Vendor Dashboard - IntelliWed Platform');
    }

    private function clientDashboard()
    {
        $user = Auth::user();

        $bookings = $user->bookings()
            ->with('items.service.vendor.user')
            ->latest()
            ->get();

        $clientStats = [
            'total_bookings'     => $bookings->count(),
            'pending_bookings'   => $bookings->where('status', 'pending')->count(),
            'confirmed_bookings' => $bookings->where('status', 'confirmed')->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
        ];

        // Wedding profile + countdown
        $weddingProfile = $user->weddingProfile;

        // Tasks summary
        $tasks = $user->tasks()->orderBy('due_date')->limit(5)->get();
        $taskStats = [
            'total'     => $user->tasks()->count(),
            'completed' => $user->tasks()->where('status', 'completed')->count(),
            'pending'   => $user->tasks()->where('status', 'pending')->count(),
        ];

        // Guest stats from invitations
        $guestStats = [
            'total'     => \App\Models\Guest::whereHas('invitation', fn($q) => $q->where('user_id', $user->id))->count(),
            'confirmed' => \App\Models\Guest::whereHas('invitation', fn($q) => $q->where('user_id', $user->id))->where('status', 'yes')->count(),
            'pending'   => \App\Models\Guest::whereHas('invitation', fn($q) => $q->where('user_id', $user->id))->where('status', 'pending')->count(),
        ];

        // Unread messages
        $unreadMessages = \App\Models\Conversation::where('client_id', $user->id)
            ->whereHas('messages', fn($q) => $q->where('sender_id', '!=', $user->id)->where('is_read', false))
            ->count();

        return view('dashboards.client', compact(
            'user', 'bookings', 'clientStats', 'weddingProfile',
            'tasks', 'taskStats', 'guestStats', 'unreadMessages'
        ))->with('header', 'Dashboard');
    }
}
