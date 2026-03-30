<?php

namespace App\Core\Auth;

use Illuminate\Http\Request;

final class AuthPipeline
{
    public function __construct(private readonly AuthManager $manager)
    {
    }

    public function attempt(string $methodKey, array $payload, Request $request): bool
    {
        return $this->manager->attempt($methodKey, $payload, $request);
    }
}

