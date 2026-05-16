<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $momo;
    protected $airtel;

    public function __construct(MomoService $momo, AirtelMoneyService $airtel)
    {
        $this->momo = $momo;
        $this->airtel = $airtel;
    }

    public function initiatePayment(Booking $booking, string $provider, string $phone)
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'provider' => $provider,
            'phone' => $phone,
            'amount_rwf' => $booking->total_price,
            'status' => 'pending',
        ]);

        try {
            if ($provider === 'momo') {
                $response = $this->momo->requestPayment($payment);
            } else {
                $response = $this->airtel->requestPayment($payment);
            }

            if ($response['success']) {
                $payment->update([
                    'status' => 'processing',
                    'provider_ref' => $response['reference'],
                    'metadata' => $response['raw'] ?? null,
                ]);
            } else {
                $payment->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            Log::error("Payment initiation failed: " . $e->getMessage());
            $payment->update(['status' => 'failed']);
        }

        return $payment;
    }

    public function processWebhook(string $provider, array $payload)
    {
        // Provider-specific logic to update payment status
        Log::info("Webhook received from $provider: ", $payload);
        
        // This is a placeholder for real webhook handling
        // In a real implementation, you'd verify the signature and find the payment by reference
    }
}
