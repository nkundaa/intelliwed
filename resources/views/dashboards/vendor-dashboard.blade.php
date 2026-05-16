@extends('layouts.modern-dashboard')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Header Section -->
    <div class="bg-white border-b border-slate-200 sticky top-16 z-40">
        <div class="container-max py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="heading-lg">Dashboard</h1>
                    <p class="text-muted mt-1">Welcome back, {{ Auth::user()->name ?? 'Vendor' }} 👋</p>
                </div>
                <button class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Booking
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-max py-8">
        <!-- Stats Grid -->
        <div class="grid-4 mb-8">
            <!-- Total Bookings -->
            <div class="card card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-muted text-sm">Total Bookings</p>
                        <p class="heading-sm text-primary mt-2">24</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex-center">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <p class="text-success text-sm mt-4">↑ 12% from last month</p>
            </div>

            <!-- Revenue -->
            <div class="card card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-muted text-sm">Total Revenue</p>
                        <p class="heading-sm text-primary mt-2">RWF 2.5M</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex-center">
                        <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-success text-sm mt-4">↑ 8% from last month</p>
            </div>

            <!-- Pending Bookings -->
            <div class="card card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-muted text-sm">Pending</p>
                        <p class="heading-sm text-warning mt-2">5</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-amber-100 flex-center">
                        <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-warning text-sm mt-4">2 require attention</p>
            </div>

            <!-- Rating -->
            <div class="card card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-muted text-sm">Average Rating</p>
                        <div class="flex items-center gap-2 mt-2">
                            <p class="heading-sm text-primary">4.8</p>
                            <span class="text-gold text-lg">★</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex-center">
                        <svg class="w-6 h-6 text-info" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-sm mt-4">Based on 48 reviews</p>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Recent Bookings -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="heading-md">Recent Bookings</h2>
                            <p class="text-muted text-sm mt-1">Your latest client bookings</p>
                        </div>
                        <a href="#" class="text-primary hover:text-primary-dark text-sm font-medium">View All →</a>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <!-- Booking Item 1 -->
                            <div class="flex items-center justify-between p-4 rounded-lg hover:bg-slate-50 transition-colors border border-slate-200">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500"></div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Alice Johnson</p>
                                            <p class="text-xs text-muted">Photography</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-slate-900">RWF 500,000</p>
                                    <div class="flex items-center gap-2 mt-1 justify-end">
                                        <span class="badge badge-success">Confirmed</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Item 2 -->
                            <div class="flex items-center justify-between p-4 rounded-lg hover:bg-slate-50 transition-colors border border-slate-200">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500"></div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Bob & Sarah</p>
                                            <p class="text-xs text-muted">Catering</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-slate-900">RWF 1,200,000</p>
                                    <div class="flex items-center gap-2 mt-1 justify-end">
                                        <span class="badge badge-warning">Pending</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Item 3 -->
                            <div class="flex items-center justify-between p-4 rounded-lg hover:bg-slate-50 transition-colors border border-slate-200">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-rose-500 to-orange-500"></div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Emma Davis</p>
                                            <p class="text-xs text-muted">Decoration</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-slate-900">RWF 750,000</p>
                                    <div class="flex items-center gap-2 mt-1 justify-end">
                                        <span class="badge badge-success">Confirmed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Quick Actions -->
            <div class="space-y-6">
                <!-- Upcoming Events -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="heading-sm">Upcoming Events</h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div class="p-3 rounded-lg bg-purple-50 border border-purple-200">
                            <p class="text-sm font-semibold text-slate-900">Garden Wedding</p>
                            <p class="text-xs text-muted mt-1">📅 May 15, 2026</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50 border border-blue-200">
                            <p class="text-sm font-semibold text-slate-900">Corporate Event</p>
                            <p class="text-xs text-muted mt-1">📅 May 20, 2026</p>
                        </div>
                        <div class="p-3 rounded-lg bg-rose-50 border border-rose-200">
                            <p class="text-sm font-semibold text-slate-900">Beach Ceremony</p>
                            <p class="text-xs text-muted mt-1">📅 June 1, 2026</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="heading-sm">Quick Actions</h3>
                    </div>
                    <div class="card-body space-y-2">
                        <button class="w-full p-3 text-left rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="text-sm font-medium">Create Package</span>
                        </button>
                        <button class="w-full p-3 text-left rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span class="text-sm font-medium">Upload Portfolio</span>
                        </button>
                        <button class="w-full p-3 text-left rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="text-sm font-medium">View Analytics</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
