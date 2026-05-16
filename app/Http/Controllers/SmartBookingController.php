<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Vendor;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{

    /**
     * Display a listing of all services (public view)
     */
    public function index(Request $request)
    {
        $query = Service::active()->with('vendor.user');

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhereHas('vendor.user', function($vq) use ($searchTerm) {
                      $vq->where('name', 'like', $searchTerm);
                  });
            });
        }

        if ($request->has('price_range') && $request->price_range != '') {
            if ($request->price_range == '0-1000') {
                $query->where('price', '<=', 1000);
            } elseif ($request->price_range == '1000-5000') {
                $query->whereBetween('price', [1000, 5000]);
            } elseif ($request->price_range == '5000+') {
                $query->where('price', '>', 5000);
            }
        }

        $services = $query->latest()->get();

        return view('services.index', compact('services'));
    }

    /**
     * Display a listing of all active vendors (public view)
     */
    public function vendorsIndex()
    {
        $vendors = Vendor::where('status', 'approved')
            ->with('user', 'services')
            ->latest()
            ->get();

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Display a specific vendor's profile (public view)
     */
    public function vendorShow(Vendor $vendor)
    {
        // Only show approved vendors
        if ($vendor->status !== 'approved') {
            abort(404);
        }

        $vendor->load(['user', 'services' => function($query) {
            $query->active()->latest();
        }]);

        return view('vendors.show', compact('vendor'));
    }

    /**
     * Display a listing of vendor's services
     */
    public function vendorServices()
    {
        $user = Auth::user();
        
        if (!$user->isVendor()) {
            abort(403);
        }

        $vendor = $user->vendor;
        $services = $vendor->services()->withCount(['bookings', 'visits'])->latest()->get();

        return view('services.vendor-index', compact('vendor', 'services'));
    }

    /**
     * Show the form for creating a new service
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isVendor()) {
            abort(403);
        }

        $categories = [
            'venue' => 'Venue',
            'car_rental' => 'Car Rental',
            'photographer' => 'Photographer',
            'decorator' => 'Decorator',
            'catering' => 'Catering',
            'music' => 'Music',
            'beauty' => 'Beauty',
            'cake' => 'Cake',
            'flowers' => 'Flowers',
            'transportation' => 'Transportation',
        ];

        return view('services.create', compact('categories'));
    }

    /**
     * Store a newly created service in storage
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isVendor()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:venue,car_rental,photographer,decorator,catering,music,beauty,cake,flowers,transportation',
            'description' => 'required|string|min:50',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'image3' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $vendor = $user->vendor;

        // Handle image uploads
        $imagePaths = [];
        foreach (['main_image', 'image2', 'image3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $image = $request->file($imageField);
                $path = $image->store('services', 'public');
                $imagePaths[$imageField] = $path;
            }
        }

        $service = Service::create([
            'vendor_id' => $vendor->id,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'contact_info' => $validated['contact_info'],
            'main_image' => $imagePaths['main_image'] ?? null,
            'image2' => $imagePaths['image2'] ?? null,
            'image3' => $imagePaths['image3'] ?? null,
            'status' => 'active',
        ]);

        return redirect()
            ->route('services.vendor')
            ->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified service
     */
    public function show(Service $service)
    {
        // Track visit for analytics
        if (Auth::check()) {
            Visit::create([
                'service_id' => $service->id,
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } else {
            Visit::create([
                'service_id' => $service->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        $service->load(['vendor.user', 'bookings.user']);
        
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service
     */
    public function edit(Service $service)
    {
        $user = Auth::user();
        
        if (!$user->isVendor() || $service->vendor_id !== $user->vendor->id) {
            abort(403);
        }

        $categories = [
            'venue' => 'Venue',
            'car_rental' => 'Car Rental',
            'photographer' => 'Photographer',
            'decorator' => 'Decorator',
            'catering' => 'Catering',
            'music' => 'Music',
            'beauty' => 'Beauty',
            'cake' => 'Cake',
            'flowers' => 'Flowers',
            'transportation' => 'Transportation',
        ];

        return view('services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service in storage
     */
    public function update(Request $request, Service $service)
    {
        $user = Auth::user();
        
        if (!$user->isVendor() || $service->vendor_id !== $user->vendor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:venue,car_rental,photographer,decorator,catering,music,beauty,cake,flowers,transportation',
            'description' => 'required|string|min:50',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image uploads
        $imagePaths = [];
        foreach (['main_image', 'image2', 'image3'] as $imageField) {
            if ($request->hasFile($imageField)) {
                // Delete old image if exists
                if ($service->$imageField) {
                    Storage::disk('public')->delete($service->$imageField);
                }
                
                $image = $request->file($imageField);
                $path = $image->store('services', 'public');
                $imagePaths[$imageField] = $path;
            }
        }

        $service->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'contact_info' => $validated['contact_info'],
            'status' => $validated['status'],
        ]);

        // Update images if new ones were uploaded
        if (!empty($imagePaths)) {
            $service->update($imagePaths);
        }

        return redirect()
            ->route('services.vendor')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service from storage
     */
    public function destroy(Service $service)
    {
        $user = Auth::user();
        
        if (!$user->isVendor() || $service->vendor_id !== $user->vendor->id) {
            abort(403);
        }

        // Delete service images
        foreach (['main_image', 'image2', 'image3'] as $imageField) {
            if ($service->$imageField) {
                Storage::disk('public')->delete($service->$imageField);
            }
        }

        $service->delete();

        return redirect()
            ->route('services.vendor')
            ->with('success', 'Service deleted successfully!');
    }

    /**
     * Admin methods for managing all services
     */
    public function adminIndex()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $services = Service::with('vendor.user')->latest()->get();

        return view('services.admin-index', compact('services'));
    }

    public function adminEdit(Service $service)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $categories = [
            'venue' => 'Venue',
            'car_rental' => 'Car Rental',
            'photographer' => 'Photographer',
            'decorator' => 'Decorator',
            'catering' => 'Catering',
            'music' => 'Music',
            'beauty' => 'Beauty',
            'cake' => 'Cake',
            'flowers' => 'Flowers',
            'transportation' => 'Transportation',
        ];

        return view('services.admin-edit', compact('service', 'categories'));
    }

    public function adminUpdate(Request $request, Service $service)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:venue,car_rental,photographer,decorator,catering,music,beauty,cake,flowers,transportation',
            'description' => 'required|string|min:50',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($validated);

        return redirect()
            ->route('services.admin')
            ->with('success', 'Service updated successfully!');
    }

    public function adminDestroy(Service $service)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            abort(403);
        }

        // Delete service images
        foreach (['main_image', 'image2', 'image3'] as $imageField) {
            if ($service->$imageField) {
                Storage::disk('public')->delete($service->$imageField);
            }
        }

        $service->delete();

        return redirect()
            ->route('services.admin')
            ->with('success', 'Service deleted successfully!');
    }
}
