<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
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

    public function badges()
    {
        return $this->hasMany(VendorBadge::class);
    }

    public function verificationRequests()
    {
        return $this->hasMany(VerificationRequest::class);
    }

    public function getIsVerifiedAttribute()
    {
        return $this->badges()->where('badge_type', 'verified')->exists();
    }

    public function getBusinessNameAttribute()
    {
        return $this->user->name;
    }

    public function getTotalBookingsAttribute()
    {
        return $this->services()->withCount('bookings')->get()->sum('bookings_count');
    }

    public function getTotalViewsAttribute()
    {
        return $this->services()->withCount('visits')->get()->sum('visits_count');
    }
}
