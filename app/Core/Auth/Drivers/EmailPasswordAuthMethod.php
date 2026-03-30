<?php

namespace App\Core\Auth\Drivers;

use App\Core\Auth\AuthMethodInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class EmailPasswordAuthMethod implements AuthMethodInterface
{
    public function key(): string
    {
        return 'email_password';
    }

    public function attempt(array $payload, Request $request): bool
    {
        $credentials = [
            'email' => $payload['email'] ?? null,
            'password' => $payload['password'] ?? null,
        ];

        $remember = (bool) ($payload['remember'] ?? false);

        return Auth::attempt($credentials, $remember);
    }
}

