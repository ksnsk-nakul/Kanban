<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('App Settings') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Editable, cached settings for marketplace buyers.') }}</p>
            </div>
        </div>

        <form method="post" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf

            @foreach ($groups as $group)
                <div class="rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
                    <div class="text-sm font-semibold">{{ __($group->name) }}</div>
                    @if ($group->description)
                        <div class="mt-1 text-xs text-zinc-500">{{ __($group->description) }}</div>
                    @endif

                    <div class="mt-4 grid gap-3 md:grid-cols-2">
                        @foreach ($group->settings as $setting)
	                            @php
	                                $fullKey = $group->key . '.' . $setting->key;
	                                $def = $definitions[$fullKey] ?? [];
	                                $input = $def['input'] ?? null;
	                                $label = $def['label'] ?? $fullKey;
	                                $hint = $def['hint'] ?? null;
	                                $placeholder = $def['placeholder'] ?? null;
	                                $options = $def['options'] ?? [];
	                                $accept = $def['accept'] ?? null;
                                    $path = null;
                                    $url = null;
	                            @endphp
                            <div class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/10 p-4">
                                <div class="text-xs text-zinc-500">{{ __($label) }}</div>
                                <div class="mt-1 text-[11px] text-zinc-500">{{ $fullKey }}</div>

                                @if ($hint)
                                    <div class="mt-2 text-[11px] text-zinc-500">{{ __($hint) }}</div>
                                @endif

                                <div class="mt-3">
                                    @if ($input === 'readonly')
                                        <div class="rounded-2xl bg-black/20 border border-white/10 px-4 py-2 text-sm text-zinc-300">
                                            {{ $setting->value ?? '—' }}
                                        </div>
                                    @elseif ($input === 'select')
                                        <select
                                            name="settings[{{ $setting->id }}]"
                                            class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm"
                                        >
                                            @foreach ($options as $ov => $ol)
                                                <option value="{{ $ov }}" @selected(old('settings.'.$setting->id, $setting->value) == $ov)>{{ __($ol) }}</option>
                                            @endforeach
                                        </select>
                                    @elseif ($input === 'textarea')
                                        <textarea
                                            name="settings[{{ $setting->id }}]"
                                            rows="3"
                                            class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20"
                                            placeholder="{{ $placeholder }}"
                                        >{{ old('settings.'.$setting->id, $setting->value) }}</textarea>
                                    @elseif ($input === 'toggle')
                                        @php($checked = filter_var(old('settings.'.$setting->id, $setting->value), FILTER_VALIDATE_BOOL))
                                        <label class="inline-flex items-center gap-3">
                                            <input type="hidden" name="settings[{{ $setting->id }}]" value="0" />
                                            <input
                                                type="checkbox"
                                                name="settings[{{ $setting->id }}]"
                                                value="1"
                                                @checked($checked)
                                                class="h-5 w-5 rounded border-white/20 bg-black/30"
                                            />
                                            <span class="text-sm text-zinc-300">{{ $checked ? __('Enabled') : __('Disabled') }}</span>
                                        </label>
                                    @elseif ($input === 'file')
                                        @php
                                            $path = $setting->value;
                                            $url = $path ? \Illuminate\Support\Facades\Storage::disk('public')->url($path) : null;
                                        @endphp
                                        @if ($url)
                                            <div class="mb-3 rounded-2xl border border-white/10 bg-black/20 p-3">
                                                <img src="{{ $url }}" alt="{{ $fullKey }}" class="max-h-20 rounded-xl" />
                                                <div class="mt-2 text-[11px] text-zinc-500">{{ $path }}</div>
                                            </div>
                                        @endif
                                        <input
                                            type="file"
                                            name="files[{{ $setting->id }}]"
                                            @if ($accept) accept="{{ $accept }}" @endif
                                            class="w-full rounded-2xl bg-black/20 border border-white/10 px-4 py-2 text-sm"
                                        />
                                    @elseif ($input === 'secret' || $setting->is_encrypted)
                                        <input
                                            type="password"
                                            name="settings[{{ $setting->id }}]"
                                            value=""
                                            placeholder="{{ __('Leave empty to keep current') }}"
                                            class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20"
                                        />
                                        <div class="mt-2 text-[11px] text-zinc-500">{{ $setting->value ? __('Saved') : __('Not set') }}</div>
                                    @else
                                        <input
                                            name="settings[{{ $setting->id }}]"
                                            value="{{ old('settings.'.$setting->id, $setting->value) }}"
                                            placeholder="{{ $placeholder }}"
                                            class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20"
                                        />
                                    @endif
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
