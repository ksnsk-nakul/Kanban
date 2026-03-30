<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssistantTask extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'title',
        'notes',
        'due_date',
        'reminder_at',
        'completed_at',
        'priority',
        'sort_order',
    ];

    protected $casts = [
        'due_date' => 'date',
        'reminder_at' => 'datetime',
        'completed_at' => 'datetime',
        'priority' => 'int',
        'sort_order' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser(Builder $query, User|int $userId): Builder
    {
        $id = $userId instanceof User ? (int) $userId->getKey() : (int) $userId;

        return $query->where('user_id', $id);
    }
}
