@extends('layouts.dashboard')

@section('title', 'Complete Your Payment')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card" x-data="paymentHandler()">
        <h2 style="margin-bottom: 1.5rem;">Secure Mobile Payment</h2>
        
        <div style="margin-bottom: 2rem; padding: 1rem; background: var(--soft-beige); border-radius: 8px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Order #{{ $booking->id }}</span>
                <span style="font-weight: 700;">RWF {{ number_format($booking->total_price, 0) }}</span>
            </div>
            <div style="font-size: 0.85rem; color: var(--text-muted);">
                Payment for: {{ $booking->service_title }}
            </div>
        </div>

        <template x-if="!processing && !success">
            <form @submit.prevent="initiatePayment">
                <div class="form-group">
                    <label class="label">Select Provider</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <label style="cursor: pointer;">
                            <input type="radio" name="provider" value="momo" x-model="formData.provider" style="display: none;">
                            <div :class="formData.provider == 'momo' ? 'card-active' : 'card-inactive'" style="padding: 1rem; text-align: center; border-radius: 8px; border: 2px solid var(--border-color);">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/MTN_Logo.svg" style="height: 30px; margin-bottom: 0.5rem;">
                                <div style="font-weight: 700;">MTN MoMo</div>
                            </div>
                        </label>
                        <label style="cursor: pointer;">
                            <input type="radio" name="provider" value="airtel" x-model="formData.provider" style="display: none;">
                            <div :class="formData.provider == 'airtel' ? 'card-active' : 'card-inactive'" style="padding: 1rem; text-align: center; border-radius: 8px; border: 2px solid var(--border-color);">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Airtel_logo.svg" style="height: 30px; margin-bottom: 0.5rem;">
                                <div style="font-weight: 700;">Airtel Money</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">Phone Number (07...)</label>
                    <input type="text" x-model="formData.phone" class="input" placeholder="07XXXXXXXX" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; height: 50px; font-size: 1.1rem; margin-top: 1rem;">
                    Pay Now
                </button>
            </form>
        </template>

        <div x-show="processing && !success" style="text-align: center; padding: 2rem 0;">
            <div class="loader" style="margin: 0 auto 1.5rem;"></div>
            <h3>Waiting for confirmation...</h3>
            <p style="color: var(--text-muted);">Please check your phone and enter your PIN to approve the transaction.</p>
        </div>

        <div x-show="success" style="text-align: center; padding: 2rem 0;">
            <div style="width: 64px; height: 64px; background: #e8f5e9; color: #2e7d32; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <svg style="width: 40px; height: 40px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </div>
            <h2>Payment Successful!</h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Your booking is now confirmed. You can view it in your dashboard.</p>
            <a href="{{ route('bookings.index') }}" class="btn btn-primary">Go to My Bookings</a>
        </div>
    </div>
</div>

<style>
    .card-active { border-color: var(--dark-neutral) !important; background: var(--soft-beige); }
    .card-inactive { border-color: var(--border-color); }
    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--dark-neutral);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<script>
function paymentHandler() {
    return {
        formData: {
            provider: 'momo',
            phone: '',
        },
        processing: false,
        success: false,
        paymentId: null,
        
        async initiatePayment() {
            this.processing = true;
            try {
                const response = await fetch('{{ route("payments.initiate", $booking->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.formData)
                });
                const data = await response.json();
                if (data.success) {
                    this.paymentId = data.payment_id;
                    this.pollStatus();
                } else {
                    alert('Payment initiation failed. Please try again.');
                    this.processing = false;
                }
            } catch (e) {
                console.error(e);
                this.processing = false;
            }
        },
        
        async pollStatus() {
            if (!this.paymentId) return;
            
            const interval = setInterval(async () => {
                try {
                    const response = await fetch(`/payments/${this.paymentId}/status`);
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        clearInterval(interval);
                        this.success = true;
                        this.processing = false;
                    } else if (data.status === 'failed') {
                        clearInterval(interval);
                        alert('Payment failed or timed out.');
                        this.processing = false;
                    }
                } catch (e) {
                    console.error(e);
                }
            }, 3000); // Poll every 3 seconds
            
            // Auto-timeout after 60 seconds
            setTimeout(() => {
                if (this.processing) {
                    clearInterval(interval);
                    this.processing = false;
                    alert('Payment session timed out.');
                }
            }, 60000);
        }
    }
}
</script>
@endsection
