@extends('layouts.front')

@section('title', 'Payment')

@section('content')
<div>
    <h1>Payment</h1>
    <p>Complete your booking payment.</p>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h2>Payment Summary</h2>
    <p>Booking Deposit: $150.00</p>
    <p>Platform Fee: $5.00</p>
    <p>Total: $155.00</p>

    <form action="#" method="POST">
        @csrf
        <label for="phone">Mobile Money Number</label>
        <input type="text" id="phone" name="phone" placeholder="e.g. 078xxxxxxx" required>

        <button type="button" onclick="alert('Payment processing simulated successfully. In a real app, this redirects to Flutterwave/MoMo.')">
            Pay Now
        </button>
    </form>

    <p><a href="/dashboard">Return to Dashboard</a></p>
</div>
@endsection
