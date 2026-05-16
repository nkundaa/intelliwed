@extends('layouts.modern-dashboard')

@section('title', 'Manage Bookings')

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Header -->
    <div class="bg-white border-b border-slate-200 sticky top-16 z-40">
        <div class="container-max py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="heading-lg">Bookings</h1>
                    <p class="text-muted mt-1">Manage and track all your bookings in one place</p>
                </div>
                <div class="flex gap-3">
                    <input 
                        type="text" 
                        placeholder="Search bookings..." 
                        class="form-input"
                    >
                    <button class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container-max py-8">
        <!-- Tabs -->
        <div class="flex gap-1 mb-6 border-b border-slate-200">
            <button class="px-4 py-3 text-primary font-medium border-b-2 border-primary">All Bookings</button>
            <button class="px-4 py-3 text-muted font-medium hover:text-slate-700">Pending</button>
            <button class="px-4 py-3 text-muted font-medium hover:text-slate-700">Confirmed</button>
            <button class="px-4 py-3 text-muted font-medium hover:text-slate-700">Completed</button>
        </div>

        <!-- Bookings Table -->
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Client</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Service</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Booking Row 1 -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500"></div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Alice & David</p>
                                        <p class="text-xs text-muted">alice@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">Photography + Video</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">May 15, 2026</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">RWF 800,000</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge badge-success">Confirmed</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-slate-200 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button class="p-2 hover:bg-slate-200 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Booking Row 2 -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500"></div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Emma & Tom</p>
                                        <p class="text-xs text-muted">emma@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">Catering Service</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">May 20, 2026</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">RWF 1,500,000</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge badge-warning">Pending</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-slate-200 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Booking Row 3 -->
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-rose-500 to-orange-500"></div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Sarah & James</p>
                                        <p class="text-xs text-muted">sarah@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">Venue & Decoration</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">June 1, 2026</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">RWF 2,000,000</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge badge-primary">In Progress</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-slate-200 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Booking Row 4 -->
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-500 to-teal-500"></div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Rachel & Mike</p>
                                        <p class="text-xs text-muted">rachel@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">Music & Entertainment</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">June 10, 2026</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">RWF 600,000</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge badge-success">Completed</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-slate-200 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer flex items-center justify-between">
                <p class="text-sm text-muted">Showing 4 of 24 bookings</p>
                <div class="flex gap-2">
                    <button class="btn btn-ghost btn-sm">← Previous</button>
                    <div class="flex gap-1">
                        <button class="w-10 h-10 rounded-lg bg-primary text-white text-sm font-medium">1</button>
                        <button class="w-10 h-10 rounded-lg hover:bg-slate-200 text-sm font-medium">2</button>
                        <button class="w-10 h-10 rounded-lg hover:bg-slate-200 text-sm font-medium">3</button>
                    </div>
                    <button class="btn btn-ghost btn-sm">Next →</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
