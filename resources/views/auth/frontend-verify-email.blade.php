<x-layouts.main>
    <section class="relative flex min-h-[calc(100vh-4rem)] items-center justify-center overflow-hidden px-4 py-16">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_45%_at_50%_40%,rgb(99_102_241_/_0.08),transparent)]" aria-hidden="true"></div>
        <div class="relative w-full max-w-sm">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 text-white/80 transition hover:text-white">
                    <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Smash Up Randomizer" class="h-8 w-8">
                    <span class="text-sm font-semibold tracking-wide">Smash Up Randomizer</span>
                </a>
            </div>
            @if(session('status') === 'verification-link-sent')
                <div class="mb-4 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-400">
                    <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                    {{ __('frontend.auth_verify_resent') }}
                </div>
            @endif
            <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm text-center">
                <div class="mb-5 flex justify-center">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full border border-white/10 bg-zinc-800/60 text-2xl text-indigo-400">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>
                <h1 class="mb-3 text-lg font-bold text-white">{{ __('frontend.auth_verify_heading') }}</h1>
                <p class="mb-6 text-sm leading-relaxed text-zinc-500">{{ __('frontend.auth_verify_body') }}</p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="sur-btn-primary w-full inline-flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                        {{ __('frontend.auth_verify_resend') }}
                    </button>
                </form>
                <form method="POST" action="{{ route('frontend.logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="text-xs text-zinc-600 transition hover:text-zinc-400">{{ __('frontend.auth_verify_logout') }}</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.main>
