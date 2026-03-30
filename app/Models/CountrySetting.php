<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountrySetting extends Model
{
    protected $fillable = [
        'country_id',
        'default_currency_code',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}

