<?php

namespace App\Core\Auth;

use Illuminate\Http\Request;

interface AuthMethodInterface
{
    public function key(): string;

    /**
     * Attempt authentication for a request.
     *
     * Return true if authenticated successfully (session or token).
     */
    public function attempt(array $payload, Request $request): bool;
}

