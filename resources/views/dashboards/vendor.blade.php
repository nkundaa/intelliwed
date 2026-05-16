@extends('layouts.dashboard')

@section('title', 'Vendor Dashboard')

@section('content')
{{-- ── Vendor Onboarding Steps ── --}}
@php
    $hasServices    = $services->count() > 0;
    $isVerified     = (bool) $vendor->is_verified;
    $hasBookings    = $bookings->count() > 0;
    $vendorDone     = (int)$hasServices + (int)$isVerified + (int)$hasBookings;
@endphp
@if($vendorDone < 3)
<div style="background: linear-gradient(135deg, #1a1a1a, #2d2d2d); border-radius: 20px; padding: 1.75rem 2rem; margin-bottom: 1.5rem; color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
            <div style="font-weight: 800; font-size: 1.05rem; color: #9bf6af;">Set up your vendor profile — {{ $vendorDone }}/3 done</div>
            <div style="font-size: 0.85rem; color: rgba(255,255,255,0.55); margin-top: 0.2rem;">Complete these steps to start receiving bookings</div>
        </div>
        <div style="background: rgba(155,246,175,0.15); border: 1px solid rgba(155,246,175,0.3); color: #9bf6af; border-radius: 99px; padding: 0.35rem 1rem; font-size: 0.8rem; font-weight: 700;">{{ round(($vendorDone/3)*100) }}%</div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('services.create') }}" style="background: rgba(255,255,255,0.07); border: 1px solid {{ $hasServices ? '#4ade80' : 'rgba(255,255,255,0.15)' }}; border-radius: 14px; padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 0.9rem; text-decoration: none; color: white; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.07)'">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $hasServices ? '#dcfce7' : 'rgba(255,255,255,0.1)' }}; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">{{ $hasServices ? '✅' : '🛍️' }}</div>
            <div><div style="font-weight: 700; font-size: 0.88rem;">Add your first service</div><div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">List what you offer</div></div>
        </a>
        <a href="{{ route('vendor.verification') }}" style="background: rgba(255,255,255,0.07); border: 1px solid {{ $isVerified ? '#4ade80' : 'rgba(255,255,255,0.15)' }}; border-radius: 14px; padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 0.9rem; text-decoration: none; color: white; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.07)'">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $isVerified ? '#dcfce7' : 'rgba(255,255,255,0.1)' }}; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">{{ $isVerified ? '✅' : '🛡️' }}</div>
            <div><div style="font-weight: 700; font-size: 0.88rem;">Get verified</div><div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">Build trust with clients</div></div>
        </a>
        <div style="background: rgba(255,255,255,0.07); border: 1px solid {{ $hasBookings ? '#4ade80' : 'rgba(255,255,255,0.15)' }}; border-radius: 14px; padding: 1.1rem 1.25rem; display: flex; align-items: center; gap: 0.9rem;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $hasBookings ? '#dcfce7' : 'rgba(255,255,255,0.1)' }}; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;">{{ $hasBookings ? '✅' : '📦' }}</div>
            <div><div style="font-weight: 700; font-size: 0.88rem; color: {{ $hasBookings ? '#4ade80' : 'rgba(255,255,255,0.9)' }};">Receive first booking</div><div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">Clients will find you</div></div>
        </div>
    </div>
</div>
@else
{{-- All done — verified badge strip --}}
<div style="background: #f0fff4; border: 1px solid #bbf7d0; border-radius: 14px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
    <span style="font-size: 1.5rem;">🌟</span>
    <div style="flex: 1;"><div style="font-weight: 700; color: #15803d;">Profile complete!</div><div style="font-size: 0.85rem; color: #555;">You're verified and receiving bookings. Keep your services updated.</div></div>
    <a href="{{ route('vendor.verification') }}" class="btn btn-outline" style="font-size: 0.85rem; flex-shrink: 0;">Manage Badges</a>
</div>
@endif

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
            <div style="font-size: 3rem; margin-bottom: 1rem;">🛍️</div>
            <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem;">No services listed yet</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.75rem; max-width: 380px; margin-left: auto; margin-right: auto;">Add your first service so clients can find and book you. It only takes a few minutes.</p>
            <a href="{{ route('services.create') }}" class="btn btn-primary" style="padding: 0.875rem 2rem;">+ Add Your First Service</a>
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
