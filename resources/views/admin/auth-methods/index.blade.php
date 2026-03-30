<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Authentication Methods') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Enable/disable drivers. At least one method must stay enabled.') }}</p>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                {{ __('App Settings') }}
            </a>
        </div>

        <div class="mt-6 rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
            <div class="overflow-hidden rounded-2xl border border-white/10">
                <table class="w-full text-sm">
                    <thead class="bg-white/60 dark:bg-black/20 text-xs text-zinc-500 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 text-left">{{ __('Key') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('Active') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach ($methods as $method)
                            <tr class="bg-white/40 dark:bg-black/10">
                                <td class="px-4 py-3 text-zinc-800 dark:text-zinc-300">{{ $method->key }}</td>
                                <td class="px-4 py-3">
                                    <form method="post" action="{{ route('admin.auth-methods.toggle', $method) }}">
                                        @csrf
                                        <button class="rounded-xl px-3 py-1.5 text-xs border border-white/10 {{ $method->enabled ? 'bg-emerald-500/15 hover:bg-emerald-500/20' : 'bg-white/5 hover:bg-white/10' }} transition">
                                            {{ $method->enabled ? __('Enabled') : __('Disabled') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
