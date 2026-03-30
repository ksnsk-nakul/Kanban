<?php

namespace App\Core\Auth;

use App\Models\AuthMethod;
use Illuminate\Http\Request;

final class AuthManager
{
    /**
     * @var array<string, AuthMethodInterface>
     */
    private array $drivers = [];

    /**
     * @param  array<int, AuthMethodInterface>  $drivers
     */
    public function __construct(array $drivers)
    {
        foreach ($drivers as $driver) {
            $this->drivers[$driver->key()] = $driver;
        }
    }

    public function attempt(string $methodKey, array $payload, Request $request): bool
    {
        if (!$this->isEnabled($methodKey)) {
            return false;
        }

        $driver = $this->drivers[$methodKey] ?? null;
        if (!$driver) {
            return false;
        }

        return $driver->attempt($payload, $request);
    }

    public function isEnabled(string $methodKey): bool
    {
        try {
            return AuthMethod::query()
                ->where('key', $methodKey)
                ->where('enabled', true)
                ->exists();
        } catch (\Throwable $e) {
            return $methodKey === 'email_password';
        }
    }
}
