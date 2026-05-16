<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WeddingProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'partner_name', 'wedding_date', 'venue', 'venue_location',
        'theme', 'ceremony_type', 'total_budget', 'guest_count_estimate',
        'love_story', 'slug', 'website_enabled', 'website_theme',
        'cover_image', 'primary_color', 'special_notes',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'website_enabled' => 'boolean',
        'total_budget' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            if (empty($profile->slug) && $profile->user) {
                $base = Str::slug($profile->user->name . '-' . now()->year);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $profile->slug = $slug;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDaysUntilWeddingAttribute(): ?int
    {
        if (!$this->wedding_date) {
            return null;
        }
        $diff = now()->diffInDays($this->wedding_date, false);
        return $diff >= 0 ? (int) $diff : null;
    }

    public function getBudgetSpentAttribute(): float
    {
        return Booking::where('user_id', $this->user_id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('total_price');
    }

    public function getBudgetRemainingAttribute(): float
    {
        if (!$this->total_budget) return 0;
        return max(0, $this->total_budget - $this->budget_spent);
    }
}
