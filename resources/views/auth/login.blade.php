<x-layouts.app>
    <div class="mx-auto max-w-md">
        <div class="glass rounded-3xl p-6">
            <div class="mb-5">
                <h1 class="text-lg font-semibold">{{ __('Login') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Use your email and password.') }}</p>
            </div>

            <div class="mb-5 rounded-3xl border border-white/10 bg-black/10 dark:bg-black/20 p-4" x-data="{ copied: null }">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm font-semibold">{{ __('Demo admin') }}</div>
                        <div class="mt-1 text-xs text-zinc-500">{{ __('Use these credentials for the first login.') }}</div>
                    </div>
                    <div class="text-xs text-emerald-300" x-show="copied" x-text="copied"></div>
                </div>

                <div class="mt-3 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-2 rounded-2xl border border-white/10 bg-black/10 dark:bg-black/30 px-3 py-2">
                        <div class="truncate">
                            <span class="text-xs text-zinc-500">{{ __('Email') }}:</span>
                            <span class="ml-1 font-medium">admin@devlife.test</span>
                        </div>
                        <button type="button"
                            class="rounded-xl border border-white/10 bg-white/5 px-3 py-1.5 text-xs hover:bg-white/10 transition"
                            x-on:click="navigator.clipboard.writeText('admin@devlife.test'); copied='{{ __('Email copied') }}'; setTimeout(()=>copied=null,1200)">
                            {{ __('Copy') }}
                        </button>
                    </div>

                    <div class="flex items-center justify-between gap-2 rounded-2xl border border-white/10 bg-black/10 dark:bg-black/30 px-3 py-2">
                        <div class="truncate">
                            <span class="text-xs text-zinc-500">{{ __('Password') }}:</span>
                            <span class="ml-1 font-medium">password</span>
                        </div>
                        <button type="button"
                            class="rounded-xl border border-white/10 bg-white/5 px-3 py-1.5 text-xs hover:bg-white/10 transition"
                            x-on:click="navigator.clipboard.writeText('password'); copied='{{ __('Password copied') }}'; setTimeout(()=>copied=null,1200)">
                            {{ __('Copy') }}
                        </button>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="method" value="{{ $method }}">

                <div>
                    <label class="text-xs text-zinc-300">{{ __('Email') }}</label>
                    <input name="email" type="email" value="{{ old('email') }}"
                        class="mt-1 w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                        required>
                </div>

                <div>
                    <label class="text-xs text-zinc-300">{{ __('Password') }}</label>
                    <input name="password" type="password"
                        class="mt-1 w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                        required>
                </div>

                <label class="flex items-center gap-2 text-xs text-zinc-300">
                    <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-black/30">
                    {{ __('Remember me') }}
                </label>

                <button class="w-full rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 py-2 text-sm transition">
                    {{ __('Continue') }}
                </button>
            </form>

            <div class="mt-5 text-center text-xs text-zinc-400">
                {{ __('New here?') }} <a href="{{ route('register') }}" class="text-zinc-200 hover:underline">{{ __('Create account') }}</a>
            </div>
        </div>
    </div>
</x-layouts.app>
