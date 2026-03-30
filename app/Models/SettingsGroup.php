<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SettingsGroup extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'sort_order',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
}

