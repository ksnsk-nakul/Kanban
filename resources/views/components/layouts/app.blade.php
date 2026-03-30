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
    $user = auth()->user();

    $activeLanguages = [];
    try {
        $activeLanguages = \App\Models\Language::query()
            ->where('active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();
    } catch (\Throwable $e) {
        $activeLanguages = [];
    }
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}" x-data="{ dark: @json($isDark), navOpen: false }" :class="{ 'dark': dark }">
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
	            <div class="relative grid gap-6 lg:grid-cols-[260px_1fr]">
                    <div x-show="navOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 lg:hidden" x-on:click="navOpen = false"></div>

	                <aside
                        class="glass rounded-3xl p-5 z-50 lg:z-auto lg:sticky lg:top-6 lg:h-[calc(100vh-3rem)]"
                        :class="navOpen ? 'fixed left-4 right-4 top-4 bottom-4 overflow-auto lg:static lg:overflow-visible' : 'hidden lg:block'"
                    >
                        <div class="flex items-center justify-between lg:hidden">
                            <div class="text-sm font-semibold">{{ config('devlife.app_name', 'DevLife OS') }}</div>
                            <button type="button"
                                    class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-xs hover:bg-white/10 transition"
                                    x-on:click="navOpen = false">
                                {{ __('Close') }}
                            </button>
                        </div>

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
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-white/10 bg-white/40 dark:bg-black/20 px-4 py-3 hover:bg-white/50 dark:hover:bg-white/5 transition">
                            <div class="text-xs text-zinc-400">{{ __('Workspace') }}</div>
                            <div class="font-semibold">{{ __('Dashboard') }}</div>
                        </a>
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                            <div class="text-xs text-zinc-400">{{ __('Tasks') }}</div>
                            <div class="font-semibold">{{ __('Board') }}</div>
                        </a>
                        @auth
                            <a href="{{ route('profile.show') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                <div class="text-xs text-zinc-400">{{ __('Account') }}</div>
                                <div class="font-semibold">{{ __('Profile') }}</div>
                            </a>
                            @if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin'))
                                <div class="mt-4 text-xs font-semibold text-zinc-400 uppercase tracking-wide">{{ __('Admin') }}</div>
                                <a href="{{ route('admin.settings.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('Admin') }}</div>
                                    <div class="font-semibold">{{ __('App Settings') }}</div>
                                </a>
                                <a href="{{ route('admin.auth-methods.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('Authentication') }}</div>
                                    <div class="font-semibold">{{ __('Authentication Methods') }}</div>
                                </a>
                                <a href="{{ route('admin.roles.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('RBAC') }}</div>
                                    <div class="font-semibold">{{ __('Roles') }}</div>
                                </a>
                                <a href="{{ route('admin.permissions.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('RBAC') }}</div>
                                    <div class="font-semibold">{{ __('Permissions') }}</div>
                                </a>
                                <a href="{{ route('admin.languages.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('Localization') }}</div>
                                    <div class="font-semibold">{{ __('Languages') }}</div>
                                </a>
                                <a href="{{ route('admin.translations.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('Localization') }}</div>
                                    <div class="font-semibold">{{ __('Translations') }}</div>
                                </a>
                                <a href="{{ route('admin.countries.index') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                                    <div class="text-xs text-zinc-400">{{ __('International') }}</div>
                                    <div class="font-semibold">{{ __('Countries') }}</div>
                                </a>
                            @endif
                        @endauth
                        <a href="{{ route('dashboard') }}" class="block rounded-2xl border border-white/10 bg-white/30 dark:bg-black/10 px-4 py-3 hover:bg-white/40 dark:hover:bg-white/5 transition">
                            <div class="text-xs text-zinc-400">{{ __('Settings') }}</div>
                            <div class="font-semibold">{{ __('Theme & Locale') }}</div>
                        </a>
                    </nav>

                    <div class="mt-6 rounded-2xl border border-white/10 bg-white/40 dark:bg-black/20 p-4">
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
                                    <button type="button"
                                            class="mb-2 inline-flex items-center gap-2 rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-3 py-2 text-sm hover:bg-white/70 dark:hover:bg-white/10 transition lg:hidden"
                                            x-on:click="navOpen = true">
                                        <span class="text-xs">{{ __('Menu') }}</span>
                                    </button>
	                                <div class="text-xs text-zinc-400">{{ __('DevLife OS') }}</div>
	                                <div class="text-sm font-semibold">{{ __('Task Manager') }}</div>
	                            </div>

                            <div class="flex items-center gap-2">
                                <div class="hidden md:block">
                                    <input
                                        type="search"
                                        placeholder="{{ __('Search') }}"
                                        class="w-[320px] rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm outline-none focus:border-black/20 dark:focus:border-white/20"
                                    />
                                </div>

                                <form method="post" action="{{ route('preferences.locale') }}" class="hidden md:block">
                                    @csrf
                                    <select name="locale" class="rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-3 py-2 text-sm"
                                            onchange="this.form.submit()">
                                        @php($current = app()->getLocale())
                                        @foreach ($activeLanguages as $language)
                                            <option value="{{ $language->code }}" @selected($current === $language->code)>
                                                {{ strtoupper($language->code) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                                <form method="post" action="{{ route('preferences.theme') }}" class="hidden md:block">
                                    @csrf
                                    <input type="hidden" name="theme_mode" :value="dark ? 'light' : 'dark'">
                                    <button type="submit"
                                            class="rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-3 py-2 text-sm hover:bg-white/70 dark:hover:bg-white/10 transition"
                                            x-on:click.prevent="dark = !dark; $el.closest('form').submit()">
                                        <span x-text="dark ? '{{ __('Light') }}' : '{{ __('Dark') }}'"></span>
                                    </button>
                                </form>

                                @auth
                                    <div class="relative" x-data="{ open: false }">
                                        <button type="button"
                                                x-on:click="open = !open"
                                                class="flex items-center gap-3 rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-3 py-2 hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="h-8 w-8 rounded-xl bg-black/10 dark:bg-white/10 grid place-items-center border border-black/10 dark:border-white/10">
                                                <span class="text-xs font-semibold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                            </div>
                                            <div class="hidden sm:block text-left leading-tight">
                                                <div class="text-sm font-semibold">{{ $user->name }}</div>
                                                <div class="text-[11px] text-zinc-500">{{ $user->email }}</div>
                                            </div>
                                            <svg class="h-4 w-4 text-zinc-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div x-show="open" x-on:click.outside="open = false" x-transition
                                             class="absolute right-0 mt-2 w-56 rounded-3xl border border-black/10 dark:border-white/10 bg-white/80 text-zinc-900 dark:bg-zinc-950/90 dark:text-zinc-100 shadow-xl backdrop-blur-lg">
                                            <div class="p-2">
                                                <a href="{{ route('profile.show') }}" class="block rounded-2xl px-3 py-2 text-sm hover:bg-white/10 transition">{{ __('Profile') }}</a>
                                                @if ($user->hasRole('super-admin') || $user->hasRole('admin'))
                                                    <a href="{{ route('admin.settings.index') }}" class="block rounded-2xl px-3 py-2 text-sm hover:bg-white/10 transition">{{ __('Admin') }} — {{ __('App Settings') }}</a>
                                                @endif
                                                <form method="post" action="{{ route('logout') }}" class="mt-1">
                                                    @csrf
                                                    <button class="w-full text-left rounded-2xl px-3 py-2 text-sm hover:bg-white/10 transition">{{ __('Logout') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endauth
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
