@php
    $dir = 'ltr';
    try {
        $lang = \App\Models\Language::query()->where('code', app()->getLocale())->first();
        if ($lang?->direction) {
            $dir = $lang->direction;
        }
    } catch (\Throwable $e) {
        $dir = 'ltr';
    }

    $themeMode = auth()->user()?->theme_mode ?? session('theme_mode', 'light');
    $isDark = $themeMode === 'dark';
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}" x-data="{ dark: @json($isDark) }" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('devlife.app_name', config('app.name')) }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="pointer-events-none absolute -top-24 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute top-24 left-8 h-[420px] w-[420px] rounded-full bg-sky-500/15 blur-3xl"></div>
            <div class="pointer-events-none absolute bottom-0 right-8 h-[460px] w-[460px] rounded-full bg-emerald-500/10 blur-3xl"></div>
        </div>

        <header class="mx-auto flex max-w-6xl items-center justify-between px-4 py-5">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-xl bg-white/10 grid place-items-center border border-white/10">
                    <span class="text-sm font-semibold">DL</span>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-semibold">{{ config('devlife.app_name', 'DevLife OS') }}</div>
                    <div class="text-xs text-zinc-400">RBAC Productivity Core</div>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <form method="post" action="{{ route('preferences.theme') }}" class="hidden md:block">
                    @csrf
                    <input type="hidden" name="theme_mode" :value="dark ? 'light' : 'dark'">
                    <button type="submit" class="glass rounded-xl px-3 py-2 text-xs text-zinc-100 hover:bg-white/15 transition"
                        x-on:click.prevent="dark = !dark; $el.closest('form').submit()">
                        <span x-text="dark ? 'Light' : 'Dark'"></span>
                    </button>
                </form>

                @auth
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="glass rounded-xl px-3 py-2 text-xs text-zinc-100 hover:bg-white/15 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="glass rounded-xl px-3 py-2 text-xs text-zinc-100 hover:bg-white/15 transition">Login</a>
                @endauth
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 pb-12">
            @if ($errors->any())
                <div class="glass mb-4 rounded-2xl p-4 text-sm text-red-200">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </body>
</html>

