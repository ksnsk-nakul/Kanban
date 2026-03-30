<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Languages') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Enable languages and pick a default (RTL/LTR ready).') }}</p>
            </div>
            <a href="{{ route('admin.translations.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                {{ __('Translations') }}
            </a>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
                <div class="text-sm font-semibold">{{ __('All languages') }}</div>

                <div class="mt-4 overflow-hidden rounded-2xl border border-white/10">
                    <table class="w-full text-sm">
                        <thead class="bg-white/60 dark:bg-black/20 text-xs text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Code') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Direction') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Active') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Default') }}</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($languages as $language)
                                <tr class="bg-white/40 dark:bg-black/10">
                                    <td class="px-4 py-3">
                                        <input
                                            form="lang-update-{{ $language->id }}"
                                            name="name"
                                            value="{{ old('name', $language->name) }}"
                                            class="w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                                        />
                                    </td>
                                    <td class="px-4 py-3 text-zinc-800 dark:text-zinc-300">{{ strtoupper($language->code) }}</td>
                                    <td class="px-4 py-3">
                                        <select form="lang-update-{{ $language->id }}" name="direction" class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm">
                                            <option value="ltr" @selected($language->direction === 'ltr')>LTR</option>
                                            <option value="rtl" @selected($language->direction === 'rtl')>RTL</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button form="lang-toggle-{{ $language->id }}" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 {{ $language->active ? 'bg-emerald-500/15 hover:bg-emerald-500/20' : 'bg-white/5 hover:bg-white/10' }} transition">
                                            {{ $language->active ? __('Active') : __('Inactive') }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($language->is_default)
                                            <span class="rounded-xl px-3 py-1.5 text-xs border border-emerald-400/30 bg-emerald-500/15">{{ __('Default') }}</span>
                                        @else
                                            <button form="lang-default-{{ $language->id }}" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                                {{ __('Set default') }}
                                            </button>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button form="lang-update-{{ $language->id }}" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                            {{ __('Update') }}
                                        </button>
                                    </td>
                                </tr>

                                <form id="lang-update-{{ $language->id }}" method="post" action="{{ route('admin.languages.update', $language) }}">
                                    @csrf
                                    @method('put')
                                </form>
                                <form id="lang-toggle-{{ $language->id }}" method="post" action="{{ route('admin.languages.toggle', $language) }}">
                                    @csrf
                                </form>
                                <form id="lang-default-{{ $language->id }}" method="post" action="{{ route('admin.languages.default', $language) }}">
                                    @csrf
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-black/10 p-5">
                <div class="text-sm font-semibold">{{ __('Add language') }}</div>
                <form method="post" action="{{ route('admin.languages.store') }}" class="mt-4 space-y-3">
                    @csrf
                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Code') }}</label>
                        <input name="code" value="{{ old('code') }}" placeholder="e.g. de"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>
                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Name') }}</label>
                        <input name="name" value="{{ old('name') }}" placeholder="e.g. German"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>
                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Direction') }}</label>
                        <select name="direction" class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm">
                            <option value="ltr">LTR</option>
                            <option value="rtl">RTL</option>
                        </select>
                    </div>

                    <button class="w-full rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Add') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
