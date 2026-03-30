<x-layouts.app>
    <div class="grid gap-6 lg:grid-cols-3">
        <section class="glass rounded-3xl p-6 lg:col-span-2">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Profile') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Update your account details.') }}</p>
            </div>

	            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
	                @csrf
	                <div>
	                    <label class="text-xs text-zinc-400">{{ __('Name') }}</label>
	                    <input name="name" value="{{ old('name', $user->name) }}"
	                           class="mt-1 w-full rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm outline-none focus:border-black/20 dark:focus:border-white/20">
	                </div>

	                <div>
	                    <label class="text-xs text-zinc-400">{{ __('Email') }}</label>
	                    <input value="{{ $user->email }}" disabled
	                           class="mt-1 w-full rounded-2xl bg-white/40 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm text-zinc-500">
	                </div>

                <button class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                    {{ __('Save') }}
                </button>
            </form>
        </section>

        <aside class="space-y-6">
            <div class="glass rounded-3xl p-6">
                <h2 class="text-sm font-semibold">{{ __('Security') }}</h2>
                <p class="text-xs text-zinc-400">{{ __('Change your password.') }}</p>

	                <form method="post" action="{{ route('profile.password') }}" class="mt-4 space-y-3">
	                    @csrf
	                    <div>
	                        <label class="text-xs text-zinc-400">{{ __('Current password') }}</label>
	                        <input type="password" name="current_password"
	                               class="mt-1 w-full rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm outline-none focus:border-black/20 dark:focus:border-white/20">
	                    </div>
	                    <div>
	                        <label class="text-xs text-zinc-400">{{ __('New password') }}</label>
	                        <input type="password" name="password"
	                               class="mt-1 w-full rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm outline-none focus:border-black/20 dark:focus:border-white/20">
	                    </div>
	                    <div>
	                        <label class="text-xs text-zinc-400">{{ __('Confirm new password') }}</label>
	                        <input type="password" name="password_confirmation"
	                               class="mt-1 w-full rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm outline-none focus:border-black/20 dark:focus:border-white/20">
	                    </div>

                    <button class="w-full rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Update password') }}
                    </button>
                </form>
            </div>

            <div class="glass rounded-3xl p-6">
                <h2 class="text-sm font-semibold">{{ __('Preferences') }}</h2>
                <p class="text-xs text-zinc-400">{{ __('Theme and language.') }}</p>

                <div class="mt-4 space-y-2">
	                    <form method="post" action="{{ route('preferences.locale') }}">
	                        @csrf
	                        <label class="text-xs text-zinc-400">{{ __('Language') }}</label>
	                        <select name="locale" class="mt-1 w-full rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm">
	                            @php($current = app()->getLocale())
	                            @foreach (\App\Models\Language::query()->where('active', true)->orderBy('name')->get() as $language)
	                                <option value="{{ $language->code }}" @selected($current === $language->code)>{{ $language->name }}</option>
                            @endforeach
                        </select>
                        <button class="mt-2 w-full rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </aside>
    </div>
</x-layouts.app>
