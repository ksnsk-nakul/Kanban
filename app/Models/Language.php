<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'direction',
        'active',
        'is_default',
    ];

    protected $casts = [
        'active' => 'bool',
        'is_default' => 'bool',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(LanguageSetting::class);
    }
}

