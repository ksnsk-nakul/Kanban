<x-layouts.app>
    <div class="glass rounded-3xl p-8">
        <div class="grid gap-6 lg:grid-cols-2 items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/20 px-3 py-1 text-xs text-zinc-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-400/70"></span>
                    <span>{{ __('Minimal core, addon-ready') }}</span>
                </div>

                <h1 class="mt-4 text-2xl font-semibold">{{ __('DevLife OS') }}</h1>
                <p class="mt-2 text-sm text-zinc-400">
                    {{ __('A modern UI template for a calm, glassmorphism task manager (RBAC + localization ready).') }}
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    <a href="{{ route('login') }}" class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">{{ __('Create account') }}</a>
                </div>

                <div class="mt-6 text-xs text-zinc-400 space-y-1">
                    <div>{{ __('Boards, tasks, progress, stages.') }}</div>
                    <div>{{ __('Built for fast shipping and clean extension via Addons.') }}</div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-black/20 p-6">
                <div class="text-sm font-semibold">{{ __('What you get') }}</div>
                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-black/30 p-4">
                        <div class="text-sm font-semibold">{{ __('Task board') }}</div>
                        <div class="mt-1 text-xs text-zinc-400">{{ __('Kanban-style layout') }}</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/30 p-4">
                        <div class="text-sm font-semibold">{{ __('Preferences') }}</div>
                        <div class="mt-1 text-xs text-zinc-400">{{ __('Theme + locale') }}</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/30 p-4">
                        <div class="text-sm font-semibold">{{ __('Addons') }}</div>
                        <div class="mt-1 text-xs text-zinc-400">{{ __('Drop-in features') }}</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/30 p-4">
                        <div class="text-sm font-semibold">{{ __('RBAC') }}</div>
                        <div class="mt-1 text-xs text-zinc-400">{{ __('Roles + permissions base') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
