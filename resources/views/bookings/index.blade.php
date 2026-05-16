@extends('layouts.dashboard')

@section('title', 'My Wedding Bookings')

@section('content')
<div x-data="bookingDashboard()">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
        <div>
            <h2 style="font-size: 2.5rem; margin-bottom: 0.5rem;">My Bookings</h2>
            <p style="color: var(--text-muted);">Manage your wedding service timeline and payments.</p>
        </div>
        <div style="display: flex; gap: 2rem; align-items: flex-end;">
            @php 
                $cart = session('booking_cart', []);
                $cartCount = count($cart);
                $cartTotal = collect($cart)->sum('price');
            @endphp
            
            @if($cartCount > 0)
                <div style="text-align: right; background: var(--soft-beige); padding: 1rem 1.5rem; border-radius: 16px; border: 1px solid var(--border-color);">
                    <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Pending Selection</div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="font-size: 1.25rem; font-weight: 800; color: var(--dark-neutral);">RWF {{ number_format($cartTotal, 0) }}</div>
                        <a href="{{ route('bookings.checkout') }}" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: 8px;">Finalize ({{ $cartCount }})</a>
                    </div>
                </div>
            @endif

            <div style="text-align: right;">
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Confirmed Investment</div>
                <div style="font-size: 2rem; font-weight: 800; color: var(--dark-neutral);">
                    RWF <span x-text="totalSpending.toLocaleString()"></span>
                </div>
            </div>
        </div>
    </div>

    @if($bookings->isEmpty())
        <div class="card" style="text-align: center; padding: 5rem 2rem; border: 2px dashed var(--border-color); background: transparent;">
            <div style="font-size: 4rem; margin-bottom: 1.5rem;">💍</div>
            <h3>No bookings yet</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Start building your dream wedding by browsing our top-rated vendors.</p>
            <a href="{{ route('services.index') }}" class="btn btn-primary">Browse Services</a>
        </div>
    @else
        <div style="display: grid; gap: 1.5rem;">
            @foreach($bookings as $booking)
                <div class="card" style="padding: 0; overflow: hidden; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                    <div style="display: flex; align-items: stretch;">
                        <div style="width: 120px; background: #f0f0f0;">
                            @if($booking->service && $booking->service->main_image)
                                <img src="{{ asset('storage/' . $booking->service->main_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                    <svg style="width: 40px; height: 40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                    <span class="badge" style="background: var(--soft-beige); color: var(--dark-neutral); font-size: 0.7rem;">{{ strtoupper($booking->service?->category ?? 'PACKAGE') }}</span>
                                    <span class="badge badge-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <h3 style="margin-bottom: 0.25rem;">{{ $booking->service->title ?? 'Multi-Service Booking' }}</h3>
                                <div style="display: flex; gap: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
                                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $booking->service?->vendor?->user?->name ?? 'Vendor' }}
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 800; font-size: 1.25rem; margin-bottom: 0.75rem;">RWF {{ number_format($booking->total_price, 0) }}</div>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.8rem; color: #c62828; border-color: #ffcdd2;">Cancel</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('payments.show', $booking->id) }}" class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.8rem;">
                                        {{ $booking->payment ? 'Receipt' : 'Pay Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Spending Breakdown (Auto-Calculated Analytics) -->
    @if(!$bookings->isEmpty())
        <div class="card" style="margin-top: 3rem; background: var(--dark-neutral); color: var(--white);">
            <h3 style="color: var(--primary-beige); margin-bottom: 2rem;">Booking Analytics</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
                <div style="border-right: 1px solid rgba(255,255,255,0.1);">
                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; margin-bottom: 0.5rem;">Confirmed Bookings</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">{{ $bookings->where('status', 'confirmed')->count() }}</div>
                </div>
                <div style="border-right: 1px solid rgba(255,255,255,0.1);">
                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; margin-bottom: 0.5rem;">Pending Requests</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">{{ $bookings->where('status', 'pending')->count() }}</div>
                </div>
                <div style="border-right: 1px solid rgba(255,255,255,0.1);">
                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; margin-bottom: 0.5rem;">Vendors Engaged</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">{{ $bookings->pluck('service.vendor_id')->unique()->count() }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; margin-bottom: 0.5rem;">Avg. Service Cost</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">RWF {{ number_format($bookings->avg('total_price'), 0) }}</div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function bookingDashboard() {
    return {
        totalSpending: {{ $bookings->sum('total_price') }},
    }
}
</script>
@endsection