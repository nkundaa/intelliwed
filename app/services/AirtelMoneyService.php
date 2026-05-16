<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AirtelMoneyService
{
    public function requestPayment(Payment $payment)
    {
        // This is a mock implementation for demonstration
        
        return [
            'success' => true,
            'reference' => 'AIRTEL-' . Str::random(10),
            'raw' => ['status' => 'pending', 'message' => 'Please enter PIN on your phone'],
        ];
    }

    public function checkStatus(string $reference)
    {
        // Mock check status
        return 'COMPLETED';
    }
}
