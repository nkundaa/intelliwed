<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\BookingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;
use App\Services\BudgetPlannerService;

class BookingController extends Controller
{
    protected $budgetPlannerService;

    public function __construct(BudgetPlannerService $budgetPlannerService)
    {
        $this->budgetPlannerService = $budgetPlannerService;
    }

    /**
     * Add service to cart
     */
    public function addToCart(Service $service)
    {
        $cart = session()->get('booking_cart', []);

        // Check if already in cart
        if (isset($cart[$service->id])) {
            return back()->with('error', 'Service already added to your booking list.');
        }

        $cart[$service->id] = [
            'id' => $service->id,
            'title' => $service->title,
            'price' => $service->price,
            'category' => $service->category,
            'vendor_name' => $service->vendor->user->name ?? 'Vendor',
        ];

        session()->put('booking_cart', $cart);

        return back()->with('success', 'Service added to your booking list!');
    }

    /**
     * Remove service from cart
     */
    public function removeFromCart($serviceId)
    {
        $cart = session()->get('booking_cart', []);

        if (isset($cart[$serviceId])) {
            unset($cart[$serviceId]);
            session()->put('booking_cart', $cart);
        }

        return back()->with('success', 'Service removed from your booking list.');
    }

    /**
     * Show checkout form
     */
    public function checkout()
    {
        $cart = session()->get('booking_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('services.index')->with('error', 'Your cart is empty.');
        }

        $cartValues = array_values($cart);
        $total = collect($cart)->sum('price');
        $subtotal = $total; // For clients, subtotal and total are the same as fees are vendor-side

        return view('bookings.checkout', [
            'cart' => $cartValues,
            'subtotal' => $subtotal,
            'total' => $total
        ]);
    }

    /**
     * Process checkout and create booking
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('booking_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('services.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'booking_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $total = collect($cart)->sum('price'); // No platform fee for client

        // Create parent booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'booking_date' => $validated['booking_date'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        // Create booking items
        foreach ($cart as $item) {
            BookingItem::create([
                'booking_id' => $booking->id,
                'service_id' => $item['id'],
                'price' => $item['price'],
            ]);
        }

        // Send notifications (optional: could be improved to notify multiple vendors)
        try {
            Mail::to('yoocoxy@gmail.com')->send(new BookingNotification($booking));
        } catch (\Exception $e) {
            \Log::error('Mail Error: ' . $e->getMessage());
        }

        // Clear cart
        session()->forget('booking_cart');

        return redirect()->route('dashboard')->with('success', 'Your multi-service booking has been submitted successfully!');
    }

    /**
     * Store a newly created booking in storage
     */
    public function store(Request $request, Service $service)
    {
        $user = Auth::user();

        if (!$user->isClient()) {
            abort(403);
        }

        // Check if user already has a pending booking for this service
        $existingBooking = Booking::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return back()->with('error', 'You already have a booking for this service.');
        }

        $validated = $request->validate([
            'booking_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking = Booking::create([
            'user_id'      => $user->id,
            'service_id'   => $service->id,
            'total_price'  => $service->price,
            'booking_date' => $validated['booking_date'],
            'notes'        => $validated['notes'],
            'status'       => 'pending',
        ]);

        // ✅ EMAIL NOTIFICATIONS
        try {
            // Notify Admin
            Mail::to('yoocoxy@gmail.com')->send(new BookingNotification($booking));
            
            // Notify Vendor if email exists
            if ($service->vendor && $service->vendor->user && $service->vendor->user->email) {
                Mail::to($service->vendor->user->email)->send(new BookingNotification($booking));
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Mail Error: ' . $e->getMessage());
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Booking created successfully! The vendor will review your request.');
    }

    /**
     * Display user's bookings
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isClient()) {
            abort(403);
        }

        $bookings = $user->bookings()
            ->with('service.vendor.user')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Display vendor's bookings
     */
    public function vendorBookings()
    {
        $user = Auth::user();
        
        if (!$user->isVendor()) {
            abort(403);
        }

        $vendor = $user->vendor;
        $serviceIds = $vendor->services->pluck('id');

        // Fetch bookings that have items belonging to this vendor OR have this vendor's service_id directly
        $bookings = Booking::where(function($query) use ($serviceIds) {
            $query->whereIn('service_id', $serviceIds)
                  ->orWhereHas('items', function($q) use ($serviceIds) {
                      $q->whereIn('service_id', $serviceIds);
                  });
        })
        ->with(['user', 'service', 'items' => function($q) use ($serviceIds) {
            $q->whereIn('service_id', $serviceIds)->with('service');
        }])
        ->latest()
        ->get();

        return view('bookings.vendor-index', compact('bookings'));
    }

    /**
     * Update booking status (for vendors)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $user = Auth::user();
        
        if (!$user->isVendor()) {
            abort(403);
        }

        // Check if booking belongs to vendor's service (either direct or via items)
        $vendor = $user->vendor;
        $serviceIds = $vendor->services->pluck('id');
        
        $belongsToVendor = $serviceIds->contains($booking->service_id) || 
                          $booking->items()->whereIn('service_id', $serviceIds)->exists();

        if (!$belongsToVendor) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Booking status updated successfully!');
    }

    /**
     * Cancel booking (for clients)
     */
    public function cancel(Booking $booking)
    {
        $user = Auth::user();
        
        if (!$user->isClient() || $booking->user_id !== $user->id) {
            abort(403);
        }

        if ($booking->status === 'completed') {
            return back()->with('error', 'Cannot cancel completed bookings.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Admin methods for managing all bookings
     */
    public function adminIndex()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $bookings = Booking::with(['user', 'service.vendor.user'])
            ->latest()
            ->get();

        return view('bookings.admin-index', compact('bookings'));
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'booking_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update($validated);

        return back()->with('success', 'Booking updated successfully!');
    }

    public function adminDestroy(Booking $booking)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $booking->delete();

        return back()->with('success', 'Booking deleted successfully!');
    }

    /**
     * Show the budget planner page
     */
    public function budgetPlanner()
    {
        return view('bookings.budget-planner');
    }

    /**
     * Suggest services based on user budget
     */
    public function suggestServices(Request $request)
    {
        $validated = $request->validate([
            'budget' => 'required|numeric|min:100000',
        ]);

        $budget = $validated['budget'];

        // Use the BudgetPlannerService to get suggestions
        $result = $this->budgetPlannerService->suggestServices($budget);

        return response()->json([
            'success' => true,
            'total_budget' => $budget,
            'total_estimated' => $result['total_estimated'] ?? 0,
            'remaining' => $result['remaining'] ?? 0,
            'suggestions' => $result['suggestions'] ?? [],
            'packages' => $result['packages'] ?? [],
        ]);
    }

    /**
     * Auto-book services based on user budget
     */
    public function autoBook(Request $request)
    {
        $validated = $request->validate([
            'budget' => 'required|numeric|min:100000',
            'package' => 'nullable|string',
        ]);

        $userId = Auth::id();
        $budget = $validated['budget'];
        $package = $validated['package'] ?? null;

        $result = $this->budgetPlannerService->autoBookServices($userId, $budget, $package);

        return response()->json([
            'success' => true,
            'message' => 'Services booked successfully!',
            'data' => $result,
        ]);
    }
}