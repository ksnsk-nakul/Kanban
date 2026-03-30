    <x-layouts.app>
	    @php
            $tasks = $tasks ?? collect();
	        $todo = $todo ?? $tasks->where('status', \App\Models\AssistantTask::STATUS_TODO);
	        $inProgress = $inProgress ?? $tasks->where('status', \App\Models\AssistantTask::STATUS_IN_PROGRESS);
	        $done = $done ?? $tasks->where('status', \App\Models\AssistantTask::STATUS_DONE);
	    @endphp

    <script>
        window.__devlife = window.__devlife || {};
        window.__devlife.reorderUrl = @json(route('assistant.tasks.reorder'));
        window.__devlife.csrf = @json(csrf_token());
    </script>

	    <div class="grid gap-6 lg:grid-cols-3">
	        <section class="glass rounded-3xl p-6 lg:col-span-2">
	            <div class="flex flex-wrap items-start justify-between gap-4">
	                <div>
	                    <h1 class="text-lg font-semibold">{{ __('Your Board') }}</h1>
	                    <p class="text-sm text-zinc-400">{{ __('A modern, calm Kanban-style view for daily execution.') }}</p>
	                </div>
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

	            <div class="mt-6 grid gap-4 md:grid-cols-3" x-data="taskBoard({
	                todo: @js(($todo ?? collect())->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'category' => $t->category])),
	                in_progress: @js(($inProgress ?? collect())->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'category' => $t->category])),
	                done: @js(($done ?? collect())->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'category' => $t->category])),
	            })">
	                <div class="rounded-3xl border border-white/10 bg-white/40 dark:bg-black/20 p-4" data-column="todo"
	                     x-on:dragover.prevent
	                     x-on:drop.prevent="drop('todo')">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('To Do') }}</div>
                        <div class="text-xs text-zinc-500" x-text="columns.todo.length"></div>
                    </div>
	                    <div class="mt-3 space-y-2">
	                        <template x-for="t in columns.todo" :key="t.id">
	                            <div class="rounded-2xl border border-white/10 bg-white/50 dark:bg-black/30 p-3 cursor-grab active:cursor-grabbing"
	                                 draggable="true"
	                                 x-on:dragstart="dragStart(t.id, 'todo')">
                                <div class="text-sm" x-text="t.title"></div>
                                <div class="mt-1 text-xs text-zinc-500" x-text="t.category"></div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-[11px] text-zinc-500">{{ __('Drag me') }}</span>
                                    <button type="button" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition"
                                            x-on:click="toggleDone(t.id)">
                                        {{ __('Done') }}
                                    </button>
                                </div>
                            </div>
                        </template>
	                        <div x-show="columns.todo.length === 0" class="rounded-2xl border border-dashed border-white/10 bg-white/40 dark:bg-black/20 p-4 text-sm text-zinc-400">
	                            {{ __('No tasks yet. Add one below.') }}
	                        </div>
	                    </div>
	                </div>
	
	                <div class="rounded-3xl border border-white/10 bg-white/40 dark:bg-black/20 p-4" data-column="in_progress"
	                     x-on:dragover.prevent
	                     x-on:drop.prevent="drop('in_progress')">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('In Progress') }}</div>
                        <div class="text-xs text-zinc-500" x-text="columns.in_progress.length"></div>
                    </div>
	                    <div class="mt-3 space-y-2">
	                        <template x-for="t in columns.in_progress" :key="t.id">
	                            <div class="rounded-2xl border border-white/10 bg-white/50 dark:bg-black/30 p-3 cursor-grab active:cursor-grabbing"
	                                 draggable="true"
	                                 x-on:dragstart="dragStart(t.id, 'in_progress')">
                                <div class="text-sm" x-text="t.title"></div>
                                <div class="mt-1 text-xs text-zinc-500" x-text="t.category"></div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-[11px] text-zinc-500">{{ __('Drag me') }}</span>
                                    <button type="button" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition"
                                            x-on:click="toggleDone(t.id)">
                                        {{ __('Done') }}
                                    </button>
                                </div>
                            </div>
                        </template>
	                        <div x-show="columns.in_progress.length === 0" class="rounded-2xl border border-dashed border-white/10 bg-white/40 dark:bg-black/20 p-4 text-sm text-zinc-400">
	                            {{ __('Drag tasks here to focus.') }}
	                        </div>
	                    </div>
	                </div>
	
	                <div class="rounded-3xl border border-white/10 bg-white/40 dark:bg-black/20 p-4" data-column="done"
	                     x-on:dragover.prevent
	                     x-on:drop.prevent="drop('done')">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">{{ __('Done') }}</div>
                        <div class="text-xs text-zinc-500" x-text="columns.done.length"></div>
                    </div>
	                    <div class="mt-3 space-y-2">
	                        <template x-for="t in columns.done" :key="t.id">
	                            <div class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/20 p-3 cursor-grab active:cursor-grabbing"
	                                 draggable="true"
	                                 x-on:dragstart="dragStart(t.id, 'done')">
                                <div class="text-sm line-through text-zinc-500" x-text="t.title"></div>
                                <div class="mt-1 text-xs text-zinc-500" x-text="t.category"></div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-[11px] text-zinc-500">{{ __('Drag me') }}</span>
                                    <button type="button" class="rounded-xl px-3 py-1.5 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition"
                                            x-on:click="toggleDone(t.id)">
                                        {{ __('Undo') }}
                                    </button>
                                </div>
                            </div>
                        </template>
	                        <div x-show="columns.done.length === 0" class="rounded-2xl border border-dashed border-white/10 bg-white/40 dark:bg-black/20 p-4 text-sm text-zinc-400">
	                            {{ __('Nothing completed yet.') }}
	                        </div>
	                    </div>
	                </div>
	            </div>

            <div class="mt-6">
                <div class="text-sm font-semibold">{{ __('Quick add') }}</div>
                <p class="text-xs text-zinc-400">{{ __('Keep tasks tiny. Ship daily.') }}</p>

	                <form method="post" action="{{ route('assistant.tasks.store') }}" class="mt-4 grid gap-2 md:grid-cols-3">
	                    @csrf
	                    <input name="title" placeholder="{{ __('Task title') }}"
	                        class="md:col-span-2 rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm outline-none focus:border-black/20 dark:focus:border-white/20" />
	                    <select name="category" class="rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm">
	                        <option>{{ __('Learning') }}</option>
	                        <option>{{ __('Work') }}</option>
	                        <option>{{ __('Health') }}</option>
	                        <option>{{ __('Personal') }}</option>
	                        <option>{{ __('Product Development') }}</option>
	                    </select>
	                    <select name="priority" class="rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm">
	                        <option value="0">{{ __('Priority: Low') }}</option>
	                        <option value="1">{{ __('Priority: Normal') }}</option>
	                        <option value="2">{{ __('Priority: High') }}</option>
	                        <option value="3">{{ __('Priority: Urgent') }}</option>
	                    </select>
	                    <button class="md:col-span-3 rounded-2xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">
	                        {{ __('Add task') }}
	                    </button>
	                </form>
            </div>
        </section>

	        <aside class="space-y-6">
	            <div class="glass rounded-3xl p-6">
	                <h2 class="text-sm font-semibold">{{ __('Priority') }}</h2>
	                <p class="text-xs text-zinc-400">{{ __('Filter tasks by priority.') }}</p>

                <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
	                    @php($p = $priority ?? '')
	                    <a href="{{ route('dashboard') }}"
	                       class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/10 px-4 py-2 text-center hover:bg-white/50 dark:hover:bg-white/5 transition {{ $p === '' ? 'bg-white/10' : '' }}">
	                        {{ __('All') }}
	                    </a>
	                    <a href="{{ route('dashboard', ['priority' => 3]) }}"
	                       class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/10 px-4 py-2 text-center hover:bg-white/50 dark:hover:bg-white/5 transition {{ $p === 3 ? 'bg-white/10' : '' }}">
	                        {{ __('Urgent') }}
	                    </a>
	                    <a href="{{ route('dashboard', ['priority' => 2]) }}"
	                       class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/10 px-4 py-2 text-center hover:bg-white/50 dark:hover:bg-white/5 transition {{ $p === 2 ? 'bg-white/10' : '' }}">
	                        {{ __('High') }}
	                    </a>
	                    <a href="{{ route('dashboard', ['priority' => 1]) }}"
	                       class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/10 px-4 py-2 text-center hover:bg-white/50 dark:hover:bg-white/5 transition {{ $p === 1 ? 'bg-white/10' : '' }}">
	                        {{ __('Normal') }}
	                    </a>
	                    <a href="{{ route('dashboard', ['priority' => 0]) }}"
	                       class="rounded-2xl border border-white/10 bg-white/40 dark:bg-black/10 px-4 py-2 text-center hover:bg-white/50 dark:hover:bg-white/5 transition col-span-2 {{ $p === 0 ? 'bg-white/10' : '' }}">
	                        {{ __('Low') }}
	                    </a>
	                </div>
	            </div>

	            <div class="glass rounded-3xl p-6">
	                <h2 class="text-sm font-semibold">{{ __('Preferences') }}</h2>
	                <p class="text-xs text-zinc-400">{{ __('Language and UX defaults.') }}</p>

                <div class="mt-4 space-y-3">
                    <form method="post" action="{{ route('preferences.locale') }}" class="space-y-2">
	                        @csrf
	                        <label class="text-xs text-zinc-400">{{ __('Language') }}</label>
	                        <select name="locale" class="w-full rounded-2xl bg-white/60 dark:bg-black/30 border border-black/10 dark:border-white/10 px-4 py-2 text-sm">
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
