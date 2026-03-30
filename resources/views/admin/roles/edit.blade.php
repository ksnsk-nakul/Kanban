<x-layouts.app>
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold">{{ __('Edit role') }}: {{ $role->name }}</h1>
                <p class="text-sm text-zinc-400">{{ __('Assign permissions to control UI visibility and access.') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.roles.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                    {{ __('Back') }}
                </a>
                @if (! $role->is_required && ! $role->is_system)
                    <form method="post" action="{{ route('admin.roles.destroy', $role) }}"
                          onsubmit="return confirm('Delete this role?');">
                        @csrf
                        @method('delete')
                        <button class="rounded-2xl bg-red-500/20 border border-red-400/30 px-4 py-2 text-sm hover:bg-red-500/30 transition">
                            {{ __('Delete') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <form method="post" action="{{ route('admin.roles.update', $role) }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-white/10 bg-black/10 p-5 md:col-span-1">
                    <div class="text-sm font-semibold">{{ __('Details') }}</div>

                    <div class="mt-4 space-y-3">
                        <div>
                            <label class="text-xs text-zinc-400">{{ __('Name') }}</label>
                            <input name="name" value="{{ old('name', $role->name) }}"
                                   class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                        </div>

                        <div>
                            <label class="text-xs text-zinc-400">{{ __('Key') }}</label>
                            <input name="slug" value="{{ old('slug', $role->slug) }}" @disabled($role->is_required)
                                   class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20 disabled:opacity-60" />
                            @if ($role->is_required)
                                <div class="mt-1 text-[11px] text-zinc-500">{{ __('Required roles cannot change key.') }}</div>
                            @endif
                        </div>

                        <div>
                            <label class="text-xs text-zinc-400">{{ __('Description') }}</label>
                            <textarea name="description" rows="4"
                                      class="mt-1 w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20">{{ old('description', $role->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-black/10 p-5 md:col-span-2">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('Permissions') }}</div>
                        <div class="text-xs text-zinc-500">{{ $role->permissions->count() }} {{ __('selected') }}</div>
                    </div>

                    <div class="mt-4 space-y-6">
                        @php($selected = $role->permissions->pluck('id')->all())

                        @foreach ($permissions as $group => $rows)
                            <div>
                                <div class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">{{ __($group) }}</div>
                                <div class="mt-2 grid gap-2 md:grid-cols-2">
                                    @foreach ($rows as $permission)
                                        <label class="flex items-start gap-3 rounded-2xl border border-white/10 bg-black/20 p-3 hover:bg-white/5 transition">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                @checked(in_array($permission->id, old('permissions', $selected), true))
                                                class="mt-1 h-4 w-4 rounded border-white/20 bg-black/30"
                                            />
                                            <div>
                                                <div class="text-sm font-medium">{{ $permission->name }}</div>
                                                <div class="text-xs text-zinc-500">{{ $permission->key }}</div>
                                                @if ($permission->description)
                                                    <div class="mt-1 text-xs text-zinc-500">{{ $permission->description }}</div>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex items-center gap-2">
                        <button class="rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                            {{ __('Save changes') }}
                        </button>
                        <a href="{{ route('admin.permissions.index') }}" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">
                            {{ __('Manage permissions') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>

