<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_budget',
        'remaining_budget',
        'allocations',
        'status',
    ];

    protected $casts = [
        'total_budget' => 'decimal:2',
        'remaining_budget' => 'decimal:2',
        'allocations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}