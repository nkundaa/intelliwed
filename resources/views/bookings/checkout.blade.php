@extends('layouts.front')

@section('title', 'Finalize Your Wedding Team')

@section('content')
<div x-data="checkoutHandler()" style="max-width: 1200px; margin: 0 auto; padding: 4rem 2rem;">
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Confirm Your Selections</h1>
        <p style="color: var(--text-muted); font-size: 1.1rem;">Review your wedding services and proceed to secure your date.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 4rem; align-items: start;">
        <!-- Left Side: Items and Form -->
        <div>
            <div class="card" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 2rem;">Selected Services</h3>
                <div style="display: grid; gap: 1.5rem;">
                    <template x-for="item in cart" :key="item.id">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                            <div style="display: flex; gap: 1.5rem; align-items: center;">
                                <div style="width: 64px; height: 64px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                    <span x-show="item.category == 'venue'">🏰</span>
                                    <span x-show="item.category == 'photographer'">📸</span>
                                    <span x-show="item.category == 'catering'">🍽️</span>
                                    <span x-show="item.category == 'music'">🎵</span>
                                    <span x-show="!['venue','photographer','catering','music'].includes(item.category)">✨</span>
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 1.1rem;" x-text="item.title"></div>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);" x-text="item.vendor_name"></div>
                                </div>
                            </div>
                            <div style="text-align: right; display: flex; align-items: center; gap: 2rem;">
                                <div style="font-weight: 800; font-size: 1.1rem;">RWF <span x-text="item.price.toLocaleString()"></span></div>
                                <button @click="removeItem(item.id)" style="background: none; border: none; color: #c62828; cursor: pointer; padding: 0.5rem;">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                    <template x-if="cart.length === 0">
                        <div style="text-align: center; padding: 3rem 0;">
                            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Your selection is empty.</p>
                            <a href="{{ route('services.index') }}" class="btn btn-primary">Browse Services</a>
                        </div>
                    </template>
                </div>
            </div>

            <form id="checkout-form" action="{{ route('bookings.process-checkout') }}" method="POST" x-show="cart.length > 0">
                @csrf
                <div class="card">
                    <h3 style="margin-bottom: 2rem;">Event Details</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div class="form-group">
                            <label class="label">Wedding Date</label>
                            <input type="date" name="booking_date" class="input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                        <div class="form-group">
                            <label class="label">Contact Phone</label>
                            <input type="text" name="phone" class="input" placeholder="07XXXXXXXX" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label">Special Instructions for Vendors</label>
                        <textarea name="notes" class="input" rows="4" placeholder="Mention any specific requests, themes, or venue details..."></textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Side: Order Summary -->
        <div style="position: sticky; top: 120px;" x-show="cart.length > 0">
            <div class="card" style="background: var(--dark-neutral); color: var(--white); padding: 2.5rem;">
                <h3 style="color: var(--primary-beige); margin-bottom: 2rem;">Investment Summary</h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.25rem;">
                    <span style="opacity: 0.7;">Services Subtotal</span>
                    <span style="font-weight: 600;">RWF <span x-text="subtotal.toLocaleString()"></span></span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.25rem; color: #4caf50;">
                    <span style="opacity: 0.9;">Platform Fees</span>
                    <span style="font-weight: 700; background: rgba(76, 175, 80, 0.2); padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.8rem;">INCLUDED</span>
                </div>

                <div x-show="discount > 0" style="display: flex; justify-content: space-between; margin-bottom: 1.25rem; color: #4caf50;">
                    <span style="opacity: 0.9;">Bundle Discount</span>
                    <span style="font-weight: 600;">- RWF <span x-text="discount.toLocaleString()"></span></span>
                </div>

                <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

                <div style="display: flex; justify-content: space-between; margin-bottom: 2.5rem;">
                    <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary-beige);">Total To Pay</span>
                    <span style="font-size: 1.75rem; font-weight: 800;">RWF <span x-text="total.toLocaleString()"></span></span>
                </div>

                <button @click="document.getElementById('checkout-form').submit()" class="btn btn-secondary" style="width: 100%; padding: 1.25rem; font-size: 1.1rem; border-radius: 99px;">
                    Confirm & Secure Dates
                </button>
                
                <div style="margin-top: 1.5rem; text-align: center; font-size: 0.8rem; opacity: 0.6; line-height: 1.5;">
                    No hidden fees for couples. Vendors pay a small commission on successful bookings.
                </div>
            </div>
            
            <div class="card" style="margin-top: 1.5rem; background: rgba(0,207,193,0.05); border: 1px solid rgba(0,207,193,0.1);">
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div style="font-size: 1.5rem;">💡</div>
                    <div style="font-size: 0.85rem; color: var(--dark-neutral);">
                        <strong>Bundle & Save:</strong> Add 3 or more services to unlock a 5% bundle discount!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkoutHandler() {
    return {
        cart: @json($cart),
        removeItem(id) {
            if (!confirm('Remove this service?')) return;
            
            fetch(`/cart/remove/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                this.cart = this.cart.filter(item => item.id != id);
                window.location.reload();
            });
        },
        get subtotal() {
            return this.cart.reduce((sum, item) => sum + parseFloat(item.price), 0);
        },
        get discount() {
            return this.cart.length >= 3 ? this.subtotal * 0.05 : 0;
        },
        get total() {
            return this.subtotal - this.discount;
        }
    }
}
</script>
@endsection
