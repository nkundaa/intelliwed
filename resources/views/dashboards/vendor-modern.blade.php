@extends('layouts.modern-dashboard')

@section('title', 'Vendor Dashboard')

@section('content')

<div class="animate-fade-in">
    <!-- Welcome Section -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ $user->name }}!</h1>
                    <p class="text-gray-600">Manage your wedding services and track your bookings</p>
                </div>
                <div class="flex items-center gap-2 mt-4 md:mt-0">
                    <span class="text-sm text-gray-500">Vendor Status:</span>
                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                        @if($vendor->status == 'approved') bg-green-100 text-green-800
                        @elseif($vendor->status == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($vendor->status) }}
                    </span>
                </div>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('services.create') }}" class="btn btn-primary">
                    <i data-lucide="plus-circle" class="icon"></i>
                    Add New Service
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $vendorStats['total_services'] ?? 0 }}</div>
                    <div class="stat-label">Total Services</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="package" class="icon text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $vendorStats['total_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="calendar" class="icon text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $vendorStats['pending_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Pending Bookings</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="clock" class="icon text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $vendorStats['confirmed_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Confirmed Bookings</div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="icon text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- My Services -->
    <div class="card mb-8">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-900">My Services</h2>
            <a href="{{ route('services.create') }}" class="btn btn-primary btn-sm">
                <i data-lucide="plus" class="icon-sm"></i>
                Add Service
            </a>
        </div>
        <div class="card-body">
            @if(isset($services) && $services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="card hover:shadow-md transition-shadow">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     alt="{{ $service->title }}" 
                                     class="w-full h-48 object-cover rounded-t-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                    <i data-lucide="image" class="icon text-gray-400"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">{{ $service->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($service->description, 100) }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-primary">${{ number_format($service->price, 2) }}</span>
                                    <div class="flex items-center gap-2">
                                        <button class="btn btn-ghost btn-sm">
                                            <i data-lucide="edit" class="icon-sm"></i>
                                        </button>
                                        <button class="btn btn-ghost btn-sm">
                                            <i data-lucide="trash-2" class="icon-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i data-lucide="package" class="icon-lg text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No services yet</h3>
                    <p class="text-gray-600 mb-4">Start by adding your first wedding service</p>
                    <a href="{{ route('services.create') }}" class="btn btn-primary">
                        <i data-lucide="plus-circle" class="icon"></i>
                        Add Your First Service
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-900">Recent Bookings</h2>
            <a href="#" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(isset($bookings) && $bookings->count() > 0)
                            @foreach($bookings->take(5) as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->service->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <button class="btn btn-ghost btn-sm">View</button>
                                            @if($booking->status == 'pending')
                                                <button class="btn btn-primary btn-sm">Confirm</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No bookings found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
