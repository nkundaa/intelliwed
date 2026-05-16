<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'event_date',
        'venue',
        'message',
        'theme',
        'token',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invitation) {
            $invitation->token = Str::random(32);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function getPublicUrlAttribute()
    {
        return route('rsvp.show', $this->token);
    }

    public function getQrCodeUrlAttribute()
    {
        $url = urlencode($this->public_url);
        return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={$url}";
    }
}
