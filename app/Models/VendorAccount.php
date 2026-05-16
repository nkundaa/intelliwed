<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorAccount extends Model
{
    protected $table = 'vendor_accounts';

    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'phone',
        'website',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}