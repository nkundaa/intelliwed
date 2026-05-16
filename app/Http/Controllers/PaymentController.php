<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function show(Booking $booking)
    {
        // Only the owner can pay
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payments.checkout', compact('booking'));
    }

    public function initiate(Request $request, Booking $booking)
    {
        $request->validate([
            'provider' => 'required|in:momo,airtel',
            'phone' => 'required|string|regex:/^07[8,9,2,3][0-9]{7}$/', // Rwanda phone format
        ]);

        $payment = $this->paymentService->initiatePayment($booking, $request->provider, $request->phone);

        return response()->json([
            'success' => true,
            'payment_id' => $payment->id,
            'status' => $payment->status,
        ]);
    }

    public function status(Payment $payment)
    {
        return response()->json([
            'status' => $payment->status,
        ]);
    }

    public function webhook(Request $request, $provider)
    {
        $this->paymentService->processWebhook($provider, $request->all());
        return response()->json(['status' => 'ok']);
    }
}
