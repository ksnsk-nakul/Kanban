<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthMethod extends Model
{
    protected $fillable = [
        'key',
        'enabled',
        'config',
        'sort_order',
    ];

    protected $casts = [
        'enabled' => 'bool',
        'config' => 'array',
    ];
}

