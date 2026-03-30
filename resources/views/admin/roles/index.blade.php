<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Roles') }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Manage required and custom roles. Required roles cannot be deleted.') }}</p>
            </div>
            <a href="{{ route('admin.permissions.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                {{ __('Permissions') }}
            </a>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-3xl border border-white/10 bg-black/10 p-5">
                <div class="text-sm font-semibold">{{ __('All roles') }}</div>
                <div class="mt-4 overflow-hidden rounded-2xl border border-white/10">
                    <table class="w-full text-sm">
                        <thead class="bg-black/20 text-xs text-zinc-400">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Key') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Permissions') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Users') }}</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($roles as $role)
                                <tr class="bg-black/10">
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $role->name }}</div>
                                        <div class="text-xs text-zinc-500">
                                            @if ($role->is_required)
                                                {{ __('Required') }}
                                            @else
                                                {{ __('Custom') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-zinc-300">{{ $role->slug }}</td>
                                    <td class="px-4 py-3 text-zinc-300">{{ $role->permissions_count }}</td>
                                    <td class="px-4 py-3 text-zinc-300">{{ $role->users_count }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.roles.edit', $role) }}"
                                           class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                            {{ __('Edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-black/10 p-5">
                <div class="text-sm font-semibold">{{ __('Add role') }}</div>
                <form method="post" action="{{ route('admin.roles.store') }}" class="mt-4 space-y-3">
                    @csrf

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Name') }}</label>
                        <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    </div>

                    <div>
                        <label class="text-xs text-zinc-400">{{ __('Key') }}</label>
                        <input name="slug" value="{{ old('slug') }}" placeholder="e.g. project-manager"
                               class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                        <div class="mt-1 text-[11px] text-zinc-500">{{ __('Leave empty to auto-generate from name.') }}</div>
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

