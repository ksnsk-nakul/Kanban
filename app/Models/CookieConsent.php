<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CookieConsent extends Model
{
    protected $fillable = [
        'user_id',
        'necessary',
        'analytics',
        'marketing',
        'locale',
        'accepted_at',
    ];

    protected $casts = [
        'necessary' => 'bool',
        'analytics' => 'bool',
        'marketing' => 'bool',
        'accepted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

