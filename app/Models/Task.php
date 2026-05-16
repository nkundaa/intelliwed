<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'status', 'due_date',
        'category', 'priority', 'is_ai_suggested', 'sort_order',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_ai_suggested' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    public static function defaultTasksFor(int $userId): void
    {
        $defaults = [
            ['title' => 'Set your wedding date', 'category' => 'ceremony', 'priority' => 'high', 'due_date' => now()->addDays(7)],
            ['title' => 'Book your venue', 'category' => 'venue', 'priority' => 'high', 'due_date' => now()->addMonths(1)],
            ['title' => 'Create guest list', 'category' => 'invitations', 'priority' => 'high', 'due_date' => now()->addMonths(1)],
            ['title' => 'Hire a photographer', 'category' => 'photography', 'priority' => 'high', 'due_date' => now()->addMonths(2)],
            ['title' => 'Plan catering menu', 'category' => 'catering', 'priority' => 'medium', 'due_date' => now()->addMonths(2)],
            ['title' => 'Choose wedding attire', 'category' => 'attire', 'priority' => 'medium', 'due_date' => now()->addMonths(2)],
            ['title' => 'Book music / DJ / band', 'category' => 'music', 'priority' => 'medium', 'due_date' => now()->addMonths(3)],
            ['title' => 'Arrange transport', 'category' => 'transport', 'priority' => 'low', 'due_date' => now()->addMonths(3)],
            ['title' => 'Send out digital invitations', 'category' => 'invitations', 'priority' => 'medium', 'due_date' => now()->addMonths(2)],
            ['title' => 'Plan traditional ceremony (Gusaba/Gukwa)', 'category' => 'ceremony', 'priority' => 'medium', 'due_date' => now()->addMonths(2)],
        ];

        foreach ($defaults as $i => $task) {
            static::create(array_merge($task, [
                'user_id' => $userId,
                'is_ai_suggested' => true,
                'sort_order' => $i,
            ]));
        }
    }
}
