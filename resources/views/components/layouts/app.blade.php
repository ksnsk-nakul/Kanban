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

    $themeMode = auth()->user()?->theme_mode ?? session('theme_mode', 'dark');
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
    <body class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 antialiased">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="pointer-events-none absolute -top-24 left-1/2 h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-fuchsia-500/20 dark:bg-fuchsia-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute top-24 left-8 h-[420px] w-[420px] rounded-full bg-sky-500/15 dark:bg-sky-500/15 blur-3xl"></div>
            <div class="pointer-events-none absolute bottom-0 right-8 h-[460px] w-[460px] rounded-full bg-emerald-500/10 dark:bg-emerald-500/10 blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-6">
            <div class="grid gap-6 lg:grid-cols-[260px_1fr]">
                <aside class="glass rounded-3xl p-5 lg:sticky lg:top-6 lg:h-[calc(100vh-3rem)]">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-2xl bg-white/10 grid place-items-center border border-white/10">
                            <span class="text-sm font-semibold">DL</span>
                        </div>
                        <div class="leading-tight">
                            <div class="text-sm font-semibold">{{ config('devlife.app_name', 'DevLife OS') }}</div>
                            <div class="text-xs text-zinc-400">{{ __('Task management core') }}</div>
                        </div>
                    </a>

                    <nav class="mt-6 space-y-2 text-sm">
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-white/10 bg-black/20 px-4 py-3 hover:bg-white/5 transition">
                            <div class="text-xs text-zinc-400">{{ __('Workspace') }}</div>
                            <div class="font-semibold">{{ __('Dashboard') }}</div>
                        </a>
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-white/10 bg-black/10 px-4 py-3 hover:bg-white/5 transition">
                            <div class="text-xs text-zinc-400">{{ __('Tasks') }}</div>
                            <div class="font-semibold">{{ __('Board') }}</div>
                        </a>
                        @auth
                            <a href="{{ route('profile.show') }}" class="block rounded-2xl border border-white/10 bg-black/10 px-4 py-3 hover:bg-white/5 transition">
                                <div class="text-xs text-zinc-400">{{ __('Account') }}</div>
                                <div class="font-semibold">{{ __('Profile') }}</div>
                            </a>
                            @if (auth()->user()->hasRole('super-admin'))
                                <a href="{{ route('admin.settings.index') }}" class="block rounded-2xl border border-white/10 bg-black/10 px-4 py-3 hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('Admin') }}</div>
                                    <div class="font-semibold">{{ __('App Settings') }}</div>
                                </a>
                            @endif
                        @endauth
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-white/10 bg-black/10 px-4 py-3 hover:bg-white/5 transition">
                            <div class="text-xs text-zinc-400">{{ __('Settings') }}</div>
                            <div class="font-semibold">{{ __('Theme & Locale') }}</div>
                        </a>
                    </nav>

                    <div class="mt-6 rounded-2xl border border-white/10 bg-black/20 p-4">
                        <div class="text-xs text-zinc-400">{{ __('Quick actions') }}</div>
                        <div class="mt-3 flex gap-2">
                            <form method="post" action="{{ route('preferences.theme') }}">
                                @csrf
                                <input type="hidden" name="theme_mode" :value="dark ? 'light' : 'dark'">
                                <button type="submit" class="rounded-xl bg-white/10 border border-white/10 px-3 py-2 text-xs hover:bg-white/15 transition"
                                    x-on:click.prevent="dark = !dark; $el.closest('form').submit()">
                                    <span x-text="dark ? '{{ __('Light') }}' : '{{ __('Dark') }}'"></span>
                                </button>
                            </form>
                            @auth
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-xs hover:bg-white/10 transition">{{ __('Logout') }}</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-xs hover:bg-white/10 transition">{{ __('Login') }}</a>
                            @endauth
                        </div>
                    </div>

                    <div class="mt-4 text-xs text-zinc-500">
                        <div>{{ __('Smooth. Minimal. Addon-ready.') }}</div>
                    </div>
                </aside>

                <div>
                    <header class="glass rounded-3xl p-4 md:p-5">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <div class="text-xs text-zinc-400">{{ __('DevLife OS') }}</div>
                                <div class="text-sm font-semibold">{{ __('Task Manager') }}</div>
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="hidden md:block">
                                    <input
                                        type="search"
                                        placeholder="{{ __('Search tasks, projects...') }}"
                                        class="w-[320px] rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20"
                                    />
                                </div>
                            </div>
                        </div>
                    </header>

                    <main class="mt-6">
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
                </div>
            </div>
        </div>
    </body>
</html>
