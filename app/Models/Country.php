<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    protected $fillable = [
        'iso2',
        'iso3',
        'name',
        'active',
        'currency_code',
    ];

    protected $casts = [
        'active' => 'bool',
    ];

    public function settings(): HasOne
    {
        return $this->hasOne(CountrySetting::class);
    }

    public function serviceLocations(): HasMany
    {
        return $this->hasMany(ServiceLocation::class);
    }
}

