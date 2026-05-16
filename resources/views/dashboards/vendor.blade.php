@extends('layouts.dashboard')

@section('title', 'Vendor Dashboard')

@section('content')
<!-- Status Alert if Pending -->
@if($vendor->status == 'pending')
    <div class="card" style="background: #fff8e1; border-color: #ffe082; color: #f57f17; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
        <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 17c-.77 1.333.192 3 1.732 3z"></path></svg>
        <div>
            <strong style="display: block;">{{ __('vendor.pending_approval') }}</strong>
            <span style="font-size: 0.9rem;">{{ __('vendor.pending_approval_msg') }}</span>
        </div>
    </div>
@endif

<div class="card" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; background: var(--soft-beige);">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="padding: 0.75rem; background: var(--white); border-radius: 50%; box-shadow: var(--shadow-sm);">
            <svg style="width: 24px; height: 24px; color: var(--dark-neutral);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-9.618 3.072 11.956 11.956 0 00-1.382 11.054 11.95 11.95 0 005.108 5.935L12 21.503l.892-.54c3.19-1.933 5.108-5.41 5.108-5.935a11.956 11.956 0 00-1.382-11.054z"></path></svg>
        </div>
        <div>
            <h4 style="margin: 0;">{{ __('vendor.trust_badge') }}</h4>
            <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">{{ $vendor->is_verified ? 'Your account is verified.' : 'Verify your account to build trust with clients.' }}</p>
        </div>
    </div>
    <a href="{{ route('vendor.verification') }}" class="btn btn-outline" style="font-size: 0.85rem;">{{ $vendor->is_verified ? 'Manage Badges' : 'Get Verified' }}</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">{{ __('vendor.total_services') }}</div>
        <div class="stat-value">{{ $vendorStats['total_services'] }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">
            {{ $vendorStats['active_services'] }} {{ __('vendor.active_services') }}
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">{{ __('vendor.total_bookings') }}</div>
        <div class="stat-value">{{ $vendorStats['total_bookings'] }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">
            From all clients
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">{{ __('vendor.total_views') }}</div>
        <div class="stat-value">{{ $vendorStats['total_views'] }}</div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">
            Profile engagement
        </div>
    </div>
    <div class="stat-card" style="background: var(--dark-neutral); color: var(--white);">
        <div class="stat-label" style="color: var(--primary-beige);">{{ __('dashboard.quick_action') }}</div>
        <div style="margin-top: 1rem;">
            <a href="{{ route('services.create') }}" class="btn btn-secondary" style="width: 100%;">{{ __('vendor.add_service') }}</a>
        </div>
    </div>
</div>

<div style="margin-bottom: 3rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem;">{{ __('vendor.my_services') }}</h2>
        <a href="{{ route('services.vendor') }}" style="color: var(--dark-neutral); font-weight: 600;">{{ __('dashboard.view_all') }} →</a>
    </div>

    @if($services->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($services->take(3) as $service)
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div style="height: 180px; position: relative;">
                        @if($service->main_image)
                            <img src="{{ asset('storage/' . $service->main_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--light-neutral); display: flex; align-items: center; justify-content: center;">
                                <svg style="width: 48px; height: 48px; color: #ccc;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div style="position: absolute; top: 1rem; right: 1rem;">
                            <span class="badge badge-{{ $service->status == 'active' ? 'approved' : 'rejected' }}">
                                {{ ucfirst($service->status) }}
                            </span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.8rem; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ $service->category }}</span>
                            <span style="font-weight: 700; color: var(--dark-neutral);">RWF {{ number_format($service->price, 0) }}</span>
                        </div>
                        <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">{{ $service->title }}</h3>
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
                            <span><strong>{{ $service->bookings_count }}</strong> Bookings</span>
                            <span><strong>{{ $service->visits_count }}</strong> Views</span>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-outline" style="flex: 1; padding: 0.5rem;">Edit</a>
                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-secondary" style="flex: 1; padding: 0.5rem;">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card" style="text-align: center; padding: 4rem 2rem;">
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">You haven't listed any services yet.</p>
            <a href="{{ route('services.create') }}" class="btn btn-primary">Create Your First Service</a>
        </div>
    @endif
</div>

<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem;">Recent Bookings</h2>
        <a href="{{ route('bookings.vendor') }}" style="color: var(--dark-neutral); font-weight: 600;">Manage All →</a>
    </div>

    @if($bookings->count() > 0)
        <div class="card" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Service(s) Booked</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td style="font-weight: 600;">{{ $booking->user->name }}</td>
                                <td>
                                    @foreach($booking->items as $item)
                                        <div style="font-size: 0.9rem;">• {{ $item->service->title }}</div>
                                    @endforeach
                                </td>
                                <td>{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'TBD' }}</td>
                                <td>
                                    <span class="badge badge-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="#" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">View Order</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card" style="text-align: center; padding: 2rem;">
            <p style="color: var(--text-muted);">No bookings yet.</p>
        </div>
    @endif
</div>
@endsection
