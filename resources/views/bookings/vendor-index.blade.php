@extends('layouts.dashboard')

@section('title', 'Manage Bookings')

@section('content')
<div class="card" style="margin-bottom: 2rem; padding: 1.5rem;">
    <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Service Bookings</h1>
    <p style="color: var(--text-muted);">Manage and track all wedding service requests from your clients.</p>
</div>

@if($bookings->count() > 0)
    <div class="space-y-4" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @foreach($bookings as $booking)
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1.5rem;">
                    <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--soft-beige); color: var(--dark-neutral); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; flex-shrink: 0;">
                            {{ substr($booking->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
                                <h3 style="margin: 0; font-size: 1.25rem;">{{ $booking->user->name }}</h3>
                                <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                            </div>
                            <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.75rem;">
                                {{ $booking->user->email }} • Booked on {{ $booking->created_at->format('M d, Y') }}
                            </div>
                            
                            <div style="background: #f9f9f9; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid var(--dark-neutral);">
                                <div style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Requested Services:</div>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    @if($booking->service)
                                        <li style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                            <span>{{ $booking->service->title }}</span>
                                            <span style="font-weight: 600;">RWF {{ number_format($booking->service->price, 0) }}</span>
                                        </li>
                                    @else
                                        @foreach($booking->items as $item)
                                            <li style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                                <span>{{ $item->service->title }}</span>
                                                <span style="font-weight: 600;">RWF {{ number_format($item->price, 0) }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            
                            @if($booking->notes)
                                <div style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                                    <span style="font-weight: 600; color: var(--dark-neutral);">Note:</span> "{{ $booking->notes }}"
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div style="text-align: right; min-width: 200px;">
                        <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Wedding Date</div>
                        <div style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">{{ $booking->booking_date->format('F d, Y') }}</div>
                        
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @if($booking->status == 'pending')
                                <form method="POST" action="{{ route('bookings.update-status', $booking->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-primary" style="width: 100%;">Confirm Booking</button>
                                </form>
                            @endif
                            
                            @if($booking->status == 'confirmed')
                                <form method="POST" action="{{ route('bookings.update-status', $booking->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; background: #2e7d32;">Mark as Completed</button>
                                </form>
                            @endif

                            @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                <form method="POST" action="{{ route('bookings.update-status', $booking->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-outline" style="width: 100%; border-color: #c62828; color: #c62828;">Cancel Request</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card" style="text-align: center; padding: 4rem 0;">
        <svg style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <h2 style="color: var(--text-muted);">No bookings found</h2>
        <p style="color: var(--text-muted);">When clients book your services, they will appear here.</p>
    </div>
@endif
@endsection
