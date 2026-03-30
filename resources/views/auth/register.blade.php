<x-layouts.app>
    <div class="mx-auto max-w-md">
        <div class="glass rounded-3xl p-6">
            <div class="mb-5">
                <h1 class="text-lg font-semibold">Create account</h1>
                <p class="text-sm text-zinc-400">Minimal setup. You can refine preferences later.</p>
            </div>

            <form method="post" action="{{ route('register.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs text-zinc-300">Name</label>
                    <input name="name" type="text" value="{{ old('name') }}"
                        class="mt-1 w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                        required>
                </div>

                <div>
                    <label class="text-xs text-zinc-300">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}"
                        class="mt-1 w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                        required>
                </div>

                <div>
                    <label class="text-xs text-zinc-300">Password</label>
                    <input name="password" type="password"
                        class="mt-1 w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                        required>
                </div>

                <div>
                    <label class="text-xs text-zinc-300">Confirm password</label>
                    <input name="password_confirmation" type="password"
                        class="mt-1 w-full rounded-xl bg-black/30 border border-white/10 px-3 py-2 text-sm outline-none focus:border-white/20"
                        required>
                </div>

                <button class="w-full rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 py-2 text-sm transition">
                    Create
                </button>
            </form>

            <div class="mt-5 text-center text-xs text-zinc-400">
                Already have an account? <a href="{{ route('login') }}" class="text-zinc-200 hover:underline">Login</a>
            </div>
        </div>
    </div>
</x-layouts.app>

