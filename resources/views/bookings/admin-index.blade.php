@extends('layouts.dashboard')

@section('title', 'Admin Booking Management')

@section('content')
<div style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.5rem; color: var(--dark-neutral);">All System Bookings</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem;">Global overview and management of all wedding service bookings.</p>
</div>

@if($bookings->count() > 0)
    <div class="card" style="padding: 0;">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service & Vendor</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--dark-neutral);">{{ $booking->user->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $booking->user->email }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $booking->service->title }}</div>
                                <div style="font-size: 0.8rem; color: var(--accent);">{{ $booking->service->vendor_name ?? 'N/A' }}</div>
                            </td>
                            <td>{{ $booking->booking_date->format('M d, Y') }}</td>
                            <td style="font-weight: 700;">${{ number_format($booking->service->price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <form method="POST" action="{{ route('bookings.admin-update', $booking->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="input" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; width: auto;">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Complete</option>
                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                        </select>
                                    </form>
                                    <form method="POST" action="{{ route('bookings.admin-destroy', $booking->id) }}" onsubmit="return confirm('Delete this booking?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #c62828; background: none; border: none; cursor: pointer;">
                                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2m3 3h.01"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="card" style="text-align: center; padding: 4rem 2rem;">
        <svg style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <h3 style="color: var(--text-muted);">No bookings found</h3>
        <p style="color: var(--text-muted);">The platform hasn't recorded any service bookings yet.</p>
    </div>
@endif
@endsection
