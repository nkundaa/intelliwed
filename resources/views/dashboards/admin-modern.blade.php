@extends('layouts.modern-dashboard')

@section('title', 'Admin Dashboard')

@section('content')

<div class="animate-fade-in">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $stats['total_users'] ?? 0 }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="icon text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $stats['total_vendors'] ?? 0 }}</div>
                    <div class="stat-label">Total Vendors</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="building" class="icon text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $stats['total_services'] ?? 0 }}</div>
                    <div class="stat-label">Total Services</div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="package" class="icon text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-number">{{ $stats['total_bookings'] ?? 0 }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="calendar" class="icon text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card mb-8">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('services.admin') }}" class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="icon text-white"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Manage Services</div>
                        <div class="text-sm text-gray-500">View and edit all services</div>
                    </div>
                </a>
                
                <a href="#" class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="icon text-white"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">User Management</div>
                        <div class="text-sm text-gray-500">Manage user accounts</div>
                    </div>
                </a>
                
                <a href="{{ route('bookings.admin') }}" class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="calendar" class="icon text-white"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Booking Overview</div>
                        <div class="text-sm text-gray-500">View all bookings</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity & Pending Vendors -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold text-gray-900">Recent Activity</h2>
                <button class="btn btn-ghost btn-sm">View All</button>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="user-plus" class="icon-sm text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">New user registered</div>
                            <div class="text-xs text-gray-500">Nkunda Carmel joined 2 hours ago</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check-circle" class="icon-sm text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">Vendor approved</div>
                            <div class="text-xs text-gray-500">Sarah's Photography approved 4 hours ago</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i data-lucide="calendar-plus" class="icon-sm text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">New booking created</div>
                            <div class="text-xs text-gray-500">Wedding photography booked 6 hours ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Vendors -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold text-gray-900">Pending Vendors</h2>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                    {{ $stats['pending_vendors'] ?? 0 }} Pending
                </span>
            </div>
            <div class="card-body">
                @if(isset($vendors) && $vendors->count() > 0)
                    <div class="space-y-4">
                        @foreach($vendors->take(5) as $vendor)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <img class="w-10 h-10 rounded-full" 
                                         src="https://ui-avatars.com/api/?name={{ $vendor->user->name }}&background=6366f1&color=fff" 
                                         alt="{{ $vendor->user->name }}">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $vendor->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $vendor->business_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="btn btn-primary btn-sm">Approve</button>
                                    <button class="btn btn-secondary btn-sm">Review</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i data-lucide="check-circle" class="icon-lg text-green-500 mx-auto mb-2"></i>
                        <p class="text-gray-500">No pending vendors</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings Table -->
    <div class="card mt-8">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-900">Recent Bookings</h2>
            <a href="{{ route('bookings.admin') }}" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $booking->id }}</td>
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
                                        <button class="btn btn-ghost btn-sm">View</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
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
