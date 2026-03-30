<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Countries') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Enable countries and select a default for currency and wallet defaults.') }}</p>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                {{ __('App Settings') }}
            </a>
        </div>

        <div class="mt-6 rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
            <form method="get" action="{{ route('admin.countries.index') }}" class="flex flex-wrap items-center gap-2">
                <input name="q" value="{{ $q }}" placeholder="{{ __('Search') }}"
                       class="w-full md:w-[420px] rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                <button class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                    {{ __('Search') }}
                </button>
            </form>

            <div class="mt-4 overflow-hidden rounded-2xl border border-white/10">
                <table class="w-full text-sm">
                    <thead class="bg-white/60 dark:bg-black/20 text-xs text-zinc-500 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                            <th class="px-4 py-3 text-left">ISO</th>
                            <th class="px-4 py-3 text-left">{{ __('Currency') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('Active') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('Default') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach ($countries as $country)
                            <tr class="bg-white/40 dark:bg-black/10">
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $country->name }}</div>
                                </td>
                                <td class="px-4 py-3 text-zinc-800 dark:text-zinc-300">{{ strtoupper($country->iso2) }}</td>
                                <td class="px-4 py-3">
                                    <select form="country-update-{{ $country->id }}" name="currency_code"
                                            class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm">
                                        <option value="">{{ __('None') }}</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->code }}" @selected($country->currency_code === $currency->code)>
                                                {{ $currency->code }} — {{ $currency->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <button form="country-toggle-{{ $country->id }}"
                                            class="rounded-xl px-3 py-1.5 text-xs border border-white/10 {{ $country->active ? 'bg-emerald-500/15 hover:bg-emerald-500/20' : 'bg-white/5 hover:bg-white/10' }} transition">
                                        {{ $country->active ? __('Active') : __('Inactive') }}
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($country->is_default)
                                        <span class="rounded-xl px-3 py-1.5 text-xs border border-emerald-400/30 bg-emerald-500/15">{{ __('Default') }}</span>
                                    @else
                                        <button form="country-default-{{ $country->id }}" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                            {{ __('Set default') }}
                                        </button>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button form="country-update-{{ $country->id }}" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                        {{ __('Update') }}
                                    </button>
                                </td>
                            </tr>

                            <form id="country-update-{{ $country->id }}" method="post" action="{{ route('admin.countries.update', $country) }}">
                                @csrf
                                @method('put')
                            </form>
                            <form id="country-toggle-{{ $country->id }}" method="post" action="{{ route('admin.countries.toggle', $country) }}">
                                @csrf
                            </form>
                            <form id="country-default-{{ $country->id }}" method="post" action="{{ route('admin.countries.default', $country) }}">
                                @csrf
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $countries->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
