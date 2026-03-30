<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'settings_group_id',
        'key',
        'value',
        'type',
        'is_public',
        'is_encrypted',
    ];

    protected $casts = [
        'is_public' => 'bool',
        'is_encrypted' => 'bool',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(SettingsGroup::class, 'settings_group_id');
    }
}

