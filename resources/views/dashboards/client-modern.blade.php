@extends('layouts.modern-dashboard')

@section('title', 'Client Dashboard')

@section('content')

<div class="animate-fade-in">
    <!-- Welcome Section -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ $user->name }}!</h1>
                    <p class="text-gray-600">Manage your wedding bookings and plan your perfect day</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('services.index') }}" class="btn btn-primary">
                        <i data-lucide="search" class="icon"></i>
                        Browse Services
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $clientStats['total_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="calendar" class="icon text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $clientStats['confirmed_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Confirmed</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="icon text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $clientStats['pending_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="clock" class="icon text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">${{ $clientStats['total_spent'] ?? 0 }}</div>
                    <div class="stat-label">Total Spent</div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="icon text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Featured Services -->
    <div class="card mb-8">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-900">Featured Services</h2>
            <a href="{{ route('services.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Photography Service -->
                <div class="card hover:shadow-md transition-shadow cursor-pointer">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="camera" class="icon text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Professional Photography</h3>
                        <p class="text-sm text-gray-600 mb-4">Capture your perfect moments with our experienced photographers</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">$2,500+</span>
                            <div class="flex items-center gap-1">
                                <i data-lucide="star" class="icon-sm text-yellow-500 fill-current"></i>
                                <span class="text-sm text-gray-600">4.9</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Venue Service -->
                <div class="card hover:shadow-md transition-shadow cursor-pointer">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="home" class="icon text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Beautiful Venues</h3>
                        <p class="text-sm text-gray-600 mb-4">Stunning wedding venues for your special day</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">$5,000+</span>
                            <div class="flex items-center gap-1">
                                <i data-lucide="star" class="icon-sm text-yellow-500 fill-current"></i>
                                <span class="text-sm text-gray-600">4.8</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Catering Service -->
                <div class="card hover:shadow-md transition-shadow cursor-pointer">
                    <div class="p-6">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="utensils" class="icon text-orange-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Premium Catering</h3>
                        <p class="text-sm text-gray-600 mb-4">Delicious cuisine for your wedding celebration</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">$1,800+</span>
                            <div class="flex items-center gap-1">
                                <i data-lucide="star" class="icon-sm text-yellow-500 fill-current"></i>
                                <span class="text-sm text-gray-600">4.7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- My Bookings -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-900">My Bookings</h2>
            <a href="#" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(isset($bookings) && $bookings->count() > 0)
                            @foreach($bookings->take(5) as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->service->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->service->vendor->user->name }}</td>
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
                                                <button class="btn btn-danger btn-sm">Cancel</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i data-lucide="calendar" class="icon-lg text-gray-400 mb-2"></i>
                                        <p>No bookings yet</p>
                                        <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm mt-2">
                                            Browse Services
                                        </a>
                                    </div>
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
