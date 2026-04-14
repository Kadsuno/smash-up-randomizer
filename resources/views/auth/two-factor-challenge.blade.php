<x-layouts.main>
    <section class="relative flex min-h-[calc(100vh-4rem)] items-center justify-center overflow-hidden px-4 py-16">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_45%_at_50%_40%,rgb(99_102_241_/_0.08),transparent)]" aria-hidden="true"></div>
        <div class="relative w-full max-w-sm">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 text-white/80 transition hover:text-white">
                    <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Smash Up Randomizer" class="h-8 w-8">
                    <span class="text-sm font-semibold tracking-wide">Smash Up Randomizer</span>
                </a>
                <p class="mt-3 text-xs font-semibold uppercase tracking-widest text-zinc-600">{{ __('frontend.two_factor_challenge_eyebrow') }}</p>
            </div>
            @if($errors->any())
                <div class="mb-4 flex items-start gap-2 rounded-lg border border-red-500/20 bg-red-900/20 px-4 py-3 text-sm text-red-400">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0" aria-hidden="true"></i>
                    <ul class="list-none">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm">
                <h1 class="mb-2 text-center text-lg font-bold text-white">{{ __('frontend.two_factor_challenge_heading') }}</h1>
                <p class="mb-6 text-center text-sm text-zinc-500">{{ __('frontend.two_factor_challenge_sub', ['email' => $email]) }}</p>
                <form method="POST" action="{{ route('two-factor.login.store') }}" novalidate>
                    @csrf
                    <div class="mb-6">
                        <label for="code" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.two_factor_code_label') }}</label>
                        <input
                            id="code"
                            type="text"
                            name="code"
                            value="{{ old('code') }}"
                            required
                            autocomplete="one-time-code"
                            inputmode="numeric"
                            autofocus
                            class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white placeholder-zinc-600 outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('code') border-red-500/40 @enderror"
                            placeholder="{{ __('frontend.two_factor_code_placeholder') }}"
                        >
                        @error('code')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 active:scale-[0.98]">
                        <i class="fa-solid fa-shield-halved text-xs" aria-hidden="true"></i>
                        {{ __('frontend.two_factor_verify') }}
                    </button>
                </form>
                <p class="mt-4 text-center text-xs text-zinc-600">{{ __('frontend.two_factor_recovery_hint') }}</p>
            </div>
        </div>
    </section>
</x-layouts.main>
