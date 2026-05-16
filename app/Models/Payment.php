<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'provider',
        'phone',
        'amount_rwf',
        'status',
        'provider_ref',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount_rwf' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}
