<footer class="sur-site-footer pt-14 pb-10 text-zinc-300 sm:pt-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-10">

            {{-- Brand col --}}
            <div class="sur-footer-col lg:col-span-5">
                <a href="{{ route('home') }}" class="mb-4 inline-flex items-center gap-3 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60" aria-label="{{ __('frontend.logo_alt') }}">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl ring-1 ring-white/[0.08]">
                        <img src="{{ asset('images/brand/logo-mark.svg') }}" class="h-8 w-8" alt="" width="32" height="32" decoding="async" aria-hidden="true">
                    </span>
                    <span class="text-base font-bold tracking-tight text-white">{{ __('frontend.footer_brand_heading') }}</span>
                </a>
                <p class="mb-5 max-w-xs text-sm leading-relaxed text-zinc-400">
                    {{ __('frontend.footer_tagline') }}
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/[0.03] px-3.5 py-2 text-xs font-medium text-zinc-400 transition duration-200 hover:border-indigo-500/30 hover:bg-indigo-500/8 hover:text-indigo-300">
                    <i class="fa-regular fa-envelope text-indigo-400" aria-hidden="true"></i>
                    Missing a faction or found a bug? Get in touch
                </a>
            </div>

            {{-- Explore col --}}
            <div class="sur-footer-col lg:col-span-3">
                <h2 class="sur-footer-heading">{{ __('frontend.footer_explore') }}</h2>
                <ul class="space-y-3">
                    <li>
                        <a class="sur-footer-link" href="{{ route('factionList') }}">{{ __('frontend.nav_factions') }}</a>
                    </li>
                    <li>
                        <a class="sur-footer-link" href="{{ route('about') }}">{{ __('frontend.nav_about') }}</a>
                    </li>
                    <li>
                        <a class="sur-footer-link" href="{{ route('contact') }}">{{ __('frontend.nav_contact') }}</a>
                    </li>
                    <li>
                        <a class="sur-footer-link inline-flex items-center gap-1.5 font-medium text-indigo-300/90 hover:text-indigo-200" href="{{ route('home') }}#wizard">
                            <i class="fa-solid fa-shuffle text-xs opacity-80" aria-hidden="true"></i>{{ __('frontend.nav_shuffle') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Legal + Social col --}}
            <div class="sur-footer-col lg:col-span-4">
                <h2 class="sur-footer-heading">{{ __('frontend.footer_legal') }}</h2>
                <ul class="mb-6 space-y-3">
                    <li>
                        <a class="sur-footer-link" href="{{ route('imprint') }}">{{ __('frontend.imprint_header') }}</a>
                    </li>
                    <li>
                        <a class="sur-footer-link" href="{{ route('privacy-policy') }}">{{ __('frontend.privacyPolicy_header') }}</a>
                    </li>
                </ul>

                <h2 class="sur-footer-heading">{{ __('frontend.footer_connect') }}</h2>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.facebook.com/SmashUpRandomizer/" class="sur-social-btn" aria-label="Facebook" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f text-lg" aria-hidden="true"></i>
                    </a>
                    <a href="https://x.com/SmashUpRando" class="sur-social-btn" aria-label="X" rel="noopener noreferrer">
                        <i class="fab fa-x-twitter text-lg" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-12 flex flex-col gap-4 border-t border-white/10 pt-8 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-zinc-500">
                {{ __('frontend.footer_copyright', ['year' => (int) date('Y')]) }}
            </p>
            @if (config('matomo.enabled'))
                <button type="button" class="text-left text-xs text-zinc-500 underline decoration-zinc-600 underline-offset-2 transition hover:text-indigo-400 sm:text-right" data-sur-open-cookie-settings>
                    {{ __('frontend.cookie_footer_cookie_settings') }}
                </button>
            @endif
        </div>
    </div>
</footer>

@if (config('matomo.enabled'))
    <x-cookie-banner />
@endif

@vite(['resources/js/app.js', 'resources/js/form.js', 'resources/js/hero.js', 'resources/js/backend.js'])
