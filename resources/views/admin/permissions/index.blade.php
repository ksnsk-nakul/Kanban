<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Permissions') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Create permissions and assign them to roles.') }}</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                {{ __('Roles') }}
            </a>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
                <form method="get" action="{{ route('admin.permissions.index') }}" class="flex items-center gap-2">
                    <input name="q" value="{{ $q }}" placeholder="{{ __('Search') }}"
                           class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    <button class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Search') }}
                    </button>
                </form>

                <div class="mt-4 overflow-hidden rounded-2xl border border-white/10">
                    <table class="w-full text-sm">
                        <thead class="bg-white/60 dark:bg-black/20 text-xs text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('Key') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Group') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($permissions as $permission)
                                <tr class="bg-white/40 dark:bg-black/10">
                                    <td class="px-4 py-3 text-zinc-800 dark:text-zinc-300">{{ $permission->key }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $permission->name }}</div>
                                        @if ($permission->description)
                                            <div class="mt-1 text-xs text-zinc-500">{{ $permission->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-zinc-800 dark:text-zinc-300">{{ $permission->group ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $permissions->links() }}
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/40 dark:bg-black/10 p-5">
                <div class="text-sm font-semibold">{{ __('Add') }} {{ __('Permission') }}</div>
                <form method="post" action="{{ route('admin.permissions.store') }}" class="mt-4 space-y-3">
                    @csrf

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Key') }}</label>
                        <input name="key" value="{{ old('key') }}" placeholder="e.g. tasks.create"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Name') }}</label>
                        <input name="name" value="{{ old('name') }}" placeholder="e.g. Create tasks"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Group') }}</label>
                        <input name="group" value="{{ old('group') }}" placeholder="e.g. tasks"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Description') }}</label>
                        <textarea name="description" rows="3"
                                  class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20">{{ old('description') }}</textarea>
                    </div>

                    <button class="w-full rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Add') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
