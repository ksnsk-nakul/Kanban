<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyConversion extends Model
{
    protected $table = 'currency_conversion';

    protected $fillable = [
        'from_currency_code',
        'to_currency_code',
        'rate',
        'active',
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'active' => 'bool',
    ];
}

