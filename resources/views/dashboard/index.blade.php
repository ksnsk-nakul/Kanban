<x-layouts.app>
    <div class="grid gap-6 lg:grid-cols-3">
        <section class="glass rounded-3xl p-6 lg:col-span-2">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold">{{ __('Your Board') }}</h1>
                    <p class="text-sm text-zinc-400">{{ __('A modern, calm Kanban-style view for daily execution.') }}</p>
                </div>

                <form method="post" action="{{ route('preferences.stage') }}" class="flex items-center gap-2">
                    @csrf
                    <label class="text-xs text-zinc-400">{{ __('Stage') }}</label>
                    <select name="stage" class="rounded-2xl bg-black/30 border border-white/10 px-3 py-2 text-xs">
                        @php($current = auth()->user()->stage)
                        <option value="recovery" @selected($current === 'recovery')>{{ __('Recovery') }}</option>
                        <option value="learning" @selected($current === 'learning')>{{ __('Learning') }}</option>
                        <option value="job_search" @selected($current === 'job_search')>{{ __('Job Search') }}</option>
                        <option value="freelance" @selected($current === 'freelance')>{{ __('Freelance') }}</option>
                        <option value="product_builder" @selected($current === 'product_builder')>{{ __('Product Builder') }}</option>
                    </select>
                    <button class="rounded-2xl bg-white/10 border border-white/10 px-3 py-2 text-xs hover:bg-white/15 transition">{{ __('Save') }}</button>
                </form>
            </div>

            <div class="mt-6">
                <div class="flex items-center justify-between text-xs text-zinc-400">
                    <span>{{ __('Daily completion') }}</span>
                    <span>{{ $percent }}%</span>
                </div>
                <div class="mt-2 h-3 w-full rounded-full bg-white/5 border border-white/10 overflow-hidden">
                    <div class="h-full bg-emerald-400/60" style="width: {{ $percent }}%"></div>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @php
                    $todo = $tasks->whereNull('completed_at');
                    $done = $tasks->whereNotNull('completed_at');
                @endphp

                <div class="rounded-3xl border border-white/10 bg-black/20 p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('To Do') }}</div>
                        <div class="text-xs text-zinc-500">{{ $todo->count() }}</div>
                    </div>
                    <div class="mt-3 space-y-2">
                        @forelse ($todo as $task)
                            <div class="rounded-2xl border border-white/10 bg-black/30 p-3">
                                <div class="text-sm">{{ $task->title }}</div>
                                <div class="mt-1 text-xs text-zinc-500">{{ $task->category }}</div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-[11px] text-zinc-500">{{ __('Today') }}</span>
                                    <form method="post" action="{{ route('assistant.tasks.toggle', $task) }}">
                                        @csrf
                                        <button class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">{{ __('Done') }}</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-white/10 bg-black/20 p-4 text-sm text-zinc-400">
                                {{ __('No tasks yet. Add one below.') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-black/20 p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('In Progress') }}</div>
                        <div class="text-xs text-zinc-500">0</div>
                    </div>
                    <div class="mt-3 space-y-2">
                        <div class="rounded-2xl border border-dashed border-white/10 bg-black/20 p-4 text-sm text-zinc-400">
                            {{ __('Template column for addons. Future status support can move tasks here.') }}
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-black/20 p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('Done') }}</div>
                        <div class="text-xs text-zinc-500">{{ $done->count() }}</div>
                    </div>
                    <div class="mt-3 space-y-2">
                        @forelse ($done as $task)
                            <div class="rounded-2xl border border-white/10 bg-black/20 p-3">
                                <div class="text-sm line-through text-zinc-500">{{ $task->title }}</div>
                                <div class="mt-1 text-xs text-zinc-500">{{ $task->category }}</div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-[11px] text-zinc-500">{{ __('Completed') }}</span>
                                    <form method="post" action="{{ route('assistant.tasks.toggle', $task) }}">
                                        @csrf
                                        <button class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">{{ __('Undo') }}</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-white/10 bg-black/20 p-4 text-sm text-zinc-400">
                                {{ __('Nothing completed yet.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div class="text-sm font-semibold">{{ __('Quick add') }}</div>
                <p class="text-xs text-zinc-400">{{ __('Keep tasks tiny. Ship daily.') }}</p>

                <form method="post" action="{{ route('assistant.tasks.store') }}" class="mt-4 grid gap-2 md:grid-cols-3">
                    @csrf
                    <input name="title" placeholder="{{ __('Task title') }}"
                        class="md:col-span-2 rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm outline-none focus:border-white/20" />
                    <select name="category" class="rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm">
                        <option>{{ __('Learning') }}</option>
                        <option>{{ __('Work') }}</option>
                        <option>{{ __('Health') }}</option>
                        <option>{{ __('Personal') }}</option>
                        <option>{{ __('Product Development') }}</option>
                    </select>
                    <button class="md:col-span-3 rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
                        {{ __('Add task') }}
                    </button>
                </form>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="glass rounded-3xl p-6">
                <h2 class="text-sm font-semibold">{{ __('Preferences') }}</h2>
                <p class="text-xs text-zinc-400">{{ __('Language and UX defaults.') }}</p>

                <div class="mt-4 space-y-3">
                    <form method="post" action="{{ route('preferences.locale') }}" class="space-y-2">
                        @csrf
                        <label class="text-xs text-zinc-400">{{ __('Language') }}</label>
                        <select name="locale" class="w-full rounded-2xl bg-black/30 border border-white/10 px-4 py-2 text-sm">
                            @php($current = app()->getLocale())
                            @foreach (\App\Models\Language::query()->where('active', true)->orderBy('name')->get() as $language)
                                <option value="{{ $language->code }}" @selected($current === $language->code)>
                                    {{ $language->name }} ({{ strtoupper($language->code) }})
                                </option>
                            @endforeach
                        </select>
                        <button class="w-full rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>

            <div class="glass rounded-3xl p-6">
                <h2 class="text-sm font-semibold">{{ __('Next steps') }}</h2>
                <p class="text-xs text-zinc-400">{{ __('Marketplace-ready path.') }}</p>
                <ul class="mt-3 space-y-2 text-sm text-zinc-300">
                    <li>{{ __('Add status + drag-and-drop (Alpine)') }}</li>
                    <li>{{ __('Add roles/permissions screens') }}</li>
                    <li>{{ __('Hook cookie banner + compliance copy') }}</li>
                </ul>
            </div>
        </aside>
    </div>
</x-layouts.app>
