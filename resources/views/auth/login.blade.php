<x-layouts.main>
    <section class="relative flex min-h-[calc(100vh-4rem)] items-center justify-center overflow-hidden px-4 py-16">

        {{-- Background glow --}}
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_45%_at_50%_40%,rgb(99_102_241_/_0.08),transparent)]" aria-hidden="true"></div>

        <div class="relative w-full max-w-sm">

            {{-- Logo + context --}}
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 text-white/80 transition hover:text-white">
                    <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Smash Up Randomizer" class="h-8 w-8">
                    <span class="text-sm font-semibold tracking-wide">Smash Up Randomizer</span>
                </a>
                <p class="mt-3 text-xs font-semibold uppercase tracking-widest text-zinc-600">Admin area</p>
            </div>

            {{-- Status message --}}
            @if(session('status'))
                <div class="mb-4 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-400">
                    <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="mb-4 flex items-start gap-2 rounded-lg border border-red-500/20 bg-red-900/20 px-4 py-3 text-sm text-red-400">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0" aria-hidden="true"></i>
                    <ul class="list-none">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card --}}
            <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm">

                <h1 class="mb-6 text-center text-lg font-bold text-white">{{ __('frontend.login') }}</h1>

                <form method="POST" action="{{ route('admin.login') }}" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">
                            {{ __('frontend.email') }}
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@example.com"
                            required
                            autofocus
                            autocomplete="email"
                            class="sur-input @error('email') border-red-500/40 @enderror"
                        >
                    </div>

                    <div class="mb-5">
                        <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">
                            {{ __('frontend.password') }}
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="sur-input @error('password') border-red-500/40 @enderror"
                        >
                    </div>

                    <div class="mb-6 flex items-center gap-2">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-white/20 bg-zinc-800 text-indigo-500 focus:ring-indigo-500/50"
                        >
                        <label for="remember_me" class="text-sm text-zinc-500">{{ __('frontend.remember_me') }}</label>
                    </div>

                    <button
                        type="submit"
                        class="sur-btn-primary w-full inline-flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-right-to-bracket text-xs" aria-hidden="true"></i>
                        {{ __('frontend.login') }}
                    </button>
                </form>
            </div>

            {{-- Back to site --}}
            <p class="mt-5 text-center text-xs text-zinc-700">
                <a href="{{ route('home') }}" class="transition hover:text-zinc-400">
                    ← Back to public site
                </a>
            </p>

        </div>
    </section>
</x-layouts.main>
