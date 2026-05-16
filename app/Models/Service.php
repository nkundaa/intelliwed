<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'vendor_id',
        'title',
        'category',
        'description',
        'price',
        'location',
        'contact_info',
        'main_image',
        'image2',
        'image3',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function getVendorNameAttribute()
    {
        return $this->vendor->user->name;
    }

    public function getBookingsCountAttribute()
    {
        return $this->bookings()->count();
    }

    public function getViewsCountAttribute()
    {
        return $this->visits()->count();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAvgRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
