<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorBadge extends Model
{
    protected $fillable = [
        'vendor_id',
        'badge_type',
        'awarded_at',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
