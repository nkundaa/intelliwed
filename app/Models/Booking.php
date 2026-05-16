<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'status',
        'booking_date',
        'notes',
        'total_price',
    ];

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getVendorNameAttribute()
    {
        return $this->service ? $this->service->vendor_name : 'Multiple Vendors';
    }

    public function getServiceTitleAttribute()
    {
        return $this->service ? $this->service->title : 'Multi-service Booking';
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }
}

