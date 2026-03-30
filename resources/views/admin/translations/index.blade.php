<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Translations') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('DB-backed translations for marketplace-friendly customization.') }}</p>
            </div>
            <a href="{{ route('admin.languages.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                {{ __('Languages') }}
            </a>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
                <form method="get" action="{{ route('admin.translations.index') }}" class="flex flex-wrap items-center gap-2">
                    <select name="lang" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm">
                        @foreach ($languages as $lang)
                            <option value="{{ $lang->code }}" @selected(($language?->code ?? '') === $lang->code)>
                                {{ $lang->name }} ({{ strtoupper($lang->code) }})
                            </option>
                        @endforeach
                    </select>
                    <input name="q" value="{{ $q }}" placeholder="{{ __('Search') }}"
                           class="w-full md:w-[340px] rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    <button class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Search') }}
                    </button>
                </form>

                <div class="mt-4 overflow-hidden rounded-2xl border border-white/10">
                    <table class="w-full text-sm">
                        <thead class="bg-white/60 dark:bg-black/20 text-xs text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('Key') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Value') }}</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($translations as $translation)
                                <tr class="bg-white/40 dark:bg-black/10 align-top">
                                    <td class="px-4 py-3">
                                        <div class="text-xs text-zinc-500">{{ $translation->key }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <textarea form="tr-update-{{ $translation->id }}" name="value" rows="2"
                                                  class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20">{{ old('value', $translation->value) }}</textarea>
                                    </td>
                                    <td class="px-4 py-3 text-right space-y-2">
                                        <button form="tr-update-{{ $translation->id }}" class="w-full rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                            {{ __('Update') }}
                                        </button>
                                        <button form="tr-delete-{{ $translation->id }}" class="w-full rounded-xl px-3 py-1.5 text-xs border border-red-400/30 bg-red-500/15 hover:bg-red-500/25 transition"
                                                onclick="return confirm('Delete translation?');">
                                            {{ __('Delete') }}
                                        </button>
                                    </td>
                                </tr>

                                <form id="tr-update-{{ $translation->id }}" method="post" action="{{ route('admin.translations.update', $translation) }}">
                                    @csrf
                                    @method('put')
                                </form>
                                <form id="tr-delete-{{ $translation->id }}" method="post" action="{{ route('admin.translations.destroy', $translation) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $translations->links() }}
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
                <div class="text-sm font-semibold">{{ __('Add') }} {{ __('Translation') }}</div>
                <form method="post" action="{{ route('admin.translations.store') }}" class="mt-4 space-y-3">
                    @csrf

                    <input type="hidden" name="language_id" value="{{ $language?->id }}" />

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Key') }}</label>
                        <input name="key" value="{{ old('key') }}" placeholder="e.g. Login"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>
                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Value') }}</label>
                        <textarea name="value" rows="3"
                                  class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20">{{ old('value') }}</textarea>
                    </div>

                    <button class="w-full rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Add') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
