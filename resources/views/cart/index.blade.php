@extends('layouts.front')

@section('title', 'Your Booking Cart | IntelliWed')

@section('content')
<div style="background: var(--soft-beige); padding: 5rem 0; border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Booking Summary</h1>
        <p style="color: var(--text-muted); max-width: 600px;">Review the services you've selected for your special day. You can add more or proceed to checkout.</p>
    </div>
</div>

<div class="container" style="padding: 4rem 2rem;">
    @if(count($cart) > 0)
        <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 3rem; align-items: start;">
            
            <!-- Cart Items -->
            <div>
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="margin: 0;">Selected Services ({{ count($cart) }})</h3>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: #c62828; font-weight: 600; cursor: pointer; font-size: 0.9rem;">Clear All</button>
                        </form>
                    </div>

                    <div style="padding: 1rem;">
                        @foreach($cart as $id => $item)
                            <div style="display: flex; gap: 1.5rem; padding: 1.5rem; border-bottom: 1px solid var(--border-color); last-child: border-bottom: none; align-items: center;">
                                <div style="width: 120px; height: 90px; border-radius: 12px; overflow: hidden; background: var(--light-neutral); flex-shrink: 0;">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                            <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div>
                                            <span style="font-size: 0.75rem; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ $item['category'] }}</span>
                                            <h4 style="margin: 0.25rem 0; font-size: 1.15rem;">{{ $item['title'] }}</h4>
                                            <p style="color: var(--text-muted); font-size: 0.9rem;">By {{ $item['vendor'] }}</p>
                                        </div>
                                        <div style="text-align: right;">
                                            <div style="font-weight: 700; font-size: 1.1rem; color: var(--dark-neutral);">${{ number_format($item['price'], 2) }}</div>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="margin-top: 0.5rem;">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; color: #c62828; cursor: pointer; font-size: 0.8rem; font-weight: 600;">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <a href="{{ route('services.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; color: var(--dark-neutral);">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Services
                    </a>
                </div>
            </div>

            <!-- Summary Panel -->
            <div style="position: sticky; top: 120px;">
                <div class="card" style="padding: 2rem;">
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">Total Estimation</h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span style="color: var(--text-muted);">Subtotal</span>
                        <span style="font-weight: 600;">${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span style="color: var(--text-muted);">Service Fee (5%)</span>
                        <span style="font-weight: 600;">${{ number_format($total * 0.05, 2) }}</span>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--border-color); margin: 1.5rem 0;">

                    <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.25rem; font-weight: 700;">
                        <span>Grand Total</span>
                        <span style="color: var(--dark-neutral);">${{ number_format($total * 1.05, 2) }}</span>
                    </div>

                    <a href="{{ route('bookings.checkout') }}" class="btn btn-primary" style="width: 100%; padding: 1.25rem;">Proceed to Checkout</a>
                    
                    <div style="margin-top: 1.5rem; text-align: center;">
                        <p style="font-size: 0.8rem; color: var(--text-muted);">
                            <svg style="width: 14px; height: 14px; display: inline; margin-bottom: -2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Secure Checkout Guarantee
                        </p>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div style="text-align: center; padding: 8rem 0;">
            <div style="width: 80px; height: 80px; background: var(--soft-beige); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                <svg style="width: 40px; height: 40px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 style="margin-bottom: 1rem;">Your booking cart is empty</h2>
            <p style="color: var(--text-muted); margin-bottom: 3rem;">Looks like you haven't selected any services yet for your dream wedding.</p>
            <a href="{{ route('services.index') }}" class="btn btn-primary">Discover Services</a>
        </div>
    @endif
</div>
@endsection
