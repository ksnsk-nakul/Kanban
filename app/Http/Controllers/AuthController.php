<?php

namespace App\Http\Controllers;

use App\Core\Auth\AuthPipeline;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login', [
            'method' => 'email_password',
        ]);
    }

    public function login(Request $request, AuthPipeline $pipeline): RedirectResponse
    {
        $payload = $request->validate([
            'method' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $ok = $pipeline->attempt((string) $payload['method'], $payload, $request);

        if (!$ok) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $defaultRole = Role::query()->where('slug', 'user')->first();
        if ($defaultRole) {
            $user->roles()->syncWithoutDetaching([$defaultRole->getKey()]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

