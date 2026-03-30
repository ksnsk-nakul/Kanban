<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('App Settings') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Editable, cached settings for marketplace buyers.') }}</p>
            </div>
        </div>

        <form method="post" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
            @csrf

            @foreach ($groups as $group)
                <div class="rounded-3xl border border-white/10 bg-black/10 p-5">
                    <div class="text-sm font-semibold">{{ __($group->name) }}</div>
                    @if ($group->description)
                        <div class="mt-1 text-xs text-zinc-500">{{ __($group->description) }}</div>
                    @endif

                    <div class="mt-4 grid gap-3 md:grid-cols-2">
                        @foreach ($group->settings as $setting)
                            <div class="rounded-2xl border border-white/10 bg-black/10 p-4">
                                <div class="text-xs text-zinc-500">{{ $group->key }}.{{ $setting->key }}</div>
                                <div class="mt-2">
                                    <input
                                        name="settings[{{ $setting->id }}]"
                                        value="{{ old('settings.'.$setting->id, $setting->value) }}"
                                        class="w-full rounded-2xl bg-black/10 dark:bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20"
                                    />
                                </div>
                                <div class="mt-2 text-[11px] text-zinc-500">{{ __('Type') }}: {{ $setting->type }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                {{ __('Save changes') }}
            </button>
        </form>
    </div>
</x-layouts.app>

