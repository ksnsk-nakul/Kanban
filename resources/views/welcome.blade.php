<x-layouts.app>
    <div class="grid gap-6 md:grid-cols-2 items-center">
        <div class="glass rounded-3xl p-8">
            <h1 class="text-2xl font-semibold">DevLife OS</h1>
            <p class="mt-2 text-sm text-zinc-400">
                Minimal RBAC + Productivity + Assistant Core. Built to be addon-extendable and marketplace-ready.
            </p>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('login') }}" class="rounded-xl bg-white/10 border border-white/10 px-4 py-2 text-sm hover:bg-white/15 transition">Login</a>
                <a href="{{ route('register') }}" class="rounded-xl bg-black/30 border border-white/10 px-4 py-2 text-sm hover:bg-white/10 transition">Create account</a>
            </div>

            <div class="mt-6 text-xs text-zinc-400 space-y-1">
                <div>Core modules: Auth, RBAC, Localization, Settings, Wallet, Countries/Locations, Notifications, Assistant.</div>
                <div>Addons live in `/Addons` and can register routes/migrations/views.</div>
            </div>
        </div>

        <div class="glass rounded-3xl p-8">
            <div class="text-sm font-semibold">Design goals</div>
            <ul class="mt-3 space-y-2 text-sm text-zinc-300">
                <li>Calm UI with glass cards</li>
                <li>Fast setup for buyers</li>
                <li>Settings cached by default</li>
                <li>RTL/LTR aware layouts</li>
            </ul>
        </div>
    </div>
</x-layouts.app>

