@php
    $googleEnabled = filled(config('services.google.client_id'));
    $githubEnabled = filled(config('services.github.client_id'));
@endphp

@if($googleEnabled || $githubEnabled)
    <div class="mt-6 border-t border-white/10 pt-6">
        <p class="mb-4 text-center text-xs font-medium uppercase tracking-wide text-zinc-500">{{ __('frontend.social_divider') }}</p>
        <div class="flex flex-col gap-3">
            @if($googleEnabled)
                <a
                    href="{{ route('social.redirect', ['provider' => 'google']) }}"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm font-semibold text-zinc-100 transition hover:bg-white/[0.1] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                >
                    <i class="fa-brands fa-google text-base" aria-hidden="true"></i>
                    {{ __('frontend.social_continue_google') }}
                </a>
            @endif
            @if($githubEnabled)
                <a
                    href="{{ route('social.redirect', ['provider' => 'github']) }}"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/[0.06] px-4 py-2.5 text-sm font-semibold text-zinc-100 transition hover:bg-white/[0.1] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                >
                    <i class="fa-brands fa-github text-base" aria-hidden="true"></i>
                    {{ __('frontend.social_continue_github') }}
                </a>
            @endif
        </div>
    </div>
@endif
