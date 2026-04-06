<footer class="border-t border-white/10 bg-black py-10 text-zinc-300">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="grid gap-10 md:grid-cols-3">
            <div>
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest text-zinc-500">Smash Up Randomizer</h2>
                <p class="text-sm leading-relaxed text-zinc-400">Shuffle and assign factions for your next Smash Up game with ease.</p>
            </div>
            <div>
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ __('frontend.footer_quick_links') }}</h2>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a class="text-zinc-300 transition hover:text-indigo-400" href="{{ route('imprint') }}">{{ __('frontend.imprint_header') }}</a>
                    </li>
                    <li>
                        <a class="text-zinc-300 transition hover:text-indigo-400" href="{{ route('privacy-policy') }}">{{ __('frontend.privacyPolicy_header') }}</a>
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="mb-3 text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ __('frontend.footer_connect') }}</h2>
                <div class="flex gap-4">
                    <a href="https://www.facebook.com/SmashUpRandomizer/" class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 text-zinc-200 transition hover:border-indigo-500/40 hover:text-indigo-400" aria-label="Facebook" rel="noopener noreferrer">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="https://x.com/SmashUpRando" class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 text-zinc-200 transition hover:border-indigo-500/40 hover:text-indigo-400" aria-label="X" rel="noopener noreferrer">
                        <i class="fab fa-x-twitter" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

@if (config('matomo.enabled'))
    <x-cookie-banner />
@endif

@vite(['resources/js/app.js', 'resources/js/form.js', 'resources/js/hero.js', 'resources/js/backend.js'])
