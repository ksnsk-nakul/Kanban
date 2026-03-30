<x-layouts.app>
    <div class="mx-auto max-w-md">
        <div class="glass rounded-3xl p-6">
            <div class="mb-5">
                <h1 class="text-lg font-semibold">Login</h1>
                <p class="text-sm text-zinc-400">Use your email and password.</p>
            </div>

            <form method="post" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="method" value="{{ $method }}">

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

                <label class="flex items-center gap-2 text-xs text-zinc-300">
                    <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-black/30">
                    Remember me
                </label>

                <button class="w-full rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 py-2 text-sm transition">
                    Continue
                </button>
            </form>

            <div class="mt-5 text-center text-xs text-zinc-400">
                New here? <a href="{{ route('register') }}" class="text-zinc-200 hover:underline">Create account</a>
            </div>
        </div>
    </div>
</x-layouts.app>

