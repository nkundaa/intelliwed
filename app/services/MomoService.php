<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MomoService
{
    public function requestPayment(Payment $payment)
    {
        // This is a mock implementation for demonstration
        // In a real scenario, you'd use the MTN MoMo API
        
        return [
            'success' => true,
            'reference' => 'MOMO-' . Str::random(10),
            'raw' => ['status' => 'initiated', 'message' => 'Payment request sent to user handset'],
        ];
    }

    public function checkStatus(string $reference)
    {
        // Mock check status
        return 'SUCCESSFUL';
    }
}
