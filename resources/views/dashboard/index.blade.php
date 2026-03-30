<x-layouts.app>
    <div class="grid gap-4 md:grid-cols-3">
        <div class="glass rounded-3xl p-6 md:col-span-2">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-lg font-semibold">Assistant Dashboard</h1>
                    <p class="text-sm text-zinc-400">Calm, minimal, distraction-free.</p>
                </div>

                <form method="post" action="{{ route('preferences.stage') }}" class="flex items-center gap-2">
                    @csrf
                    <label class="text-xs text-zinc-400">Stage</label>
                    <select name="stage" class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-xs">
                        @php($current = auth()->user()->stage)
                        <option value="recovery" @selected($current === 'recovery')>Recovery</option>
                        <option value="learning" @selected($current === 'learning')>Learning</option>
                        <option value="job_search" @selected($current === 'job_search')>Job Search</option>
                        <option value="freelance" @selected($current === 'freelance')>Freelance</option>
                        <option value="product_builder" @selected($current === 'product_builder')>Product Builder</option>
                    </select>
                    <button class="rounded-xl bg-white/10 border border-white/10 px-3 py-2 text-xs hover:bg-white/15 transition">Save</button>
                </form>
            </div>

            <div class="mt-6">
                <div class="flex items-center justify-between text-xs text-zinc-400">
                    <span>Daily completion</span>
                    <span>{{ $percent }}%</span>
                </div>
                <div class="mt-2 h-3 w-full rounded-full bg-white/5 border border-white/10 overflow-hidden">
                    <div class="h-full bg-emerald-400/60" style="width: {{ $percent }}%"></div>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-sm font-semibold">Tasks</h2>
                <p class="text-xs text-zinc-400">Add small tasks and build momentum.</p>

                <form method="post" action="{{ route('assistant.tasks.store') }}" class="mt-4 grid gap-2 md:grid-cols-3">
                    @csrf
                    <input name="title" placeholder="Task title"
                        class="md:col-span-2 rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20" />
                    <select name="category" class="rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm">
                        <option>Learning</option>
                        <option>Work</option>
                        <option>Health</option>
                        <option>Personal</option>
                        <option>Product Development</option>
                    </select>
                    <button class="md:col-span-3 rounded-xl bg-white/10 border border-white/10 px-3 py-2 text-sm hover:bg-white/15 transition">
                        Add task
                    </button>
                </form>

                <div class="mt-4 space-y-2">
                    @forelse ($tasks as $task)
                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-black/20 border border-white/10 px-4 py-3">
                            <div>
                                <div class="text-sm {{ $task->completed_at ? 'line-through text-zinc-500' : '' }}">
                                    {{ $task->title }}
                                </div>
                                <div class="text-xs text-zinc-500">{{ $task->category }}</div>
                            </div>
                            <form method="post" action="{{ route('assistant.tasks.toggle', $task) }}">
                                @csrf
                                <button class="rounded-xl px-3 py-2 text-xs border border-white/10 bg-white/5 hover:bg-white/10 transition">
                                    {{ $task->completed_at ? 'Undo' : 'Done' }}
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-sm text-zinc-400 mt-2">No tasks yet. Add your first one.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="glass rounded-3xl p-6">
            <h2 class="text-sm font-semibold">Preferences</h2>
            <p class="text-xs text-zinc-400">Theme and language.</p>

            <div class="mt-4 space-y-3">
                <form method="post" action="{{ route('preferences.locale') }}" class="space-y-2">
                    @csrf
                    <label class="text-xs text-zinc-400">Language</label>
                    <select name="locale" class="w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm">
                        @php($current = app()->getLocale())
                        @foreach (\App\Models\Language::query()->where('active', true)->orderBy('name')->get() as $language)
                            <option value="{{ $language->code }}" @selected($current === $language->code)>
                                {{ $language->name }} ({{ strtoupper($language->code) }})
                            </option>
                        @endforeach
                    </select>
                    <button class="w-full rounded-xl bg-white/10 border border-white/10 px-3 py-2 text-sm hover:bg-white/15 transition">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>

