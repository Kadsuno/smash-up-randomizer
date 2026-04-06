<x-layouts.main>
    <div class="mx-auto max-w-3xl px-4 pb-16 pt-24 text-zinc-100 sm:px-6" x-data="{ open: 1 }">
        <div class="sur-card mb-8 border-white/10">
            <h1 class="mb-4 text-center text-2xl font-bold text-white sm:text-3xl">
                {{ __('frontend.privacyPolicy_header') }}
            </h1>
            <p class="text-center leading-relaxed text-zinc-400">
                {{ __('frontend.privacyPolicy_teaser') }}
            </p>

            <div class="mt-8 space-y-2">
                <div class="overflow-hidden rounded-xl border border-white/10">
                    <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80 sm:text-base"
                        @click="open = open === 1 ? 0 : 1"
                        :aria-expanded="open === 1">
                        {{ __('frontend.privacyPolicy_dataCollection_header') }}
                        <i class="fas fa-chevron-down shrink-0 text-zinc-500 transition" :class="open === 1 && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === 1" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                        <p class="mb-3">{{ __('frontend.privacyPolicy_dataCollection_body') }}</p>
                        <p class="mb-3">{{ __('frontend.privacyPolicy_consent_body') }}</p>
                        <p>{{ __('frontend.privacyPolicy_matomo_body') }}</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-white/10">
                    <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80 sm:text-base"
                        @click="open = open === 2 ? 0 : 2"
                        :aria-expanded="open === 2">
                        {{ __('frontend.privacyPolicy_security_header') }}
                        <i class="fas fa-chevron-down shrink-0 text-zinc-500 transition" :class="open === 2 && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === 2" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                        <p>{{ __('frontend.privacyPolicy_security_body') }}</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-white/10">
                    <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80 sm:text-base"
                        @click="open = open === 3 ? 0 : 3"
                        :aria-expanded="open === 3">
                        {{ __('frontend.privacyPolicy_cookies_header') }}
                        <i class="fas fa-chevron-down shrink-0 text-zinc-500 transition" :class="open === 3 && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === 3" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                        <p class="mb-3">{{ __('frontend.privacyPolicy_cookies_body') }}</p>
                        <p>{{ __('frontend.privacyPolicy_consent_cookies_body') }}</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-white/10">
                    <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80 sm:text-base"
                        @click="open = open === 4 ? 0 : 4"
                        :aria-expanded="open === 4">
                        {{ __('frontend.privacyPolicy_rights_header') }}
                        <i class="fas fa-chevron-down shrink-0 text-zinc-500 transition" :class="open === 4 && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === 4" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                        <p>{{ __('frontend.privacyPolicy_rights_body') }}</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-white/10">
                    <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80 sm:text-base"
                        @click="open = open === 5 ? 0 : 5"
                        :aria-expanded="open === 5">
                        {{ __('frontend.privacyPolicy_dataSharing_header') }}
                        <i class="fas fa-chevron-down shrink-0 text-zinc-500 transition" :class="open === 5 && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === 5" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                        <p class="mb-3">{{ __('frontend.privacyPolicy_dataSharing_body') }}</p>
                        <p>{{ __('frontend.privacyPolicy_matomo_dataSharing_body') }}</p>
                    </div>
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-zinc-500">
                {{ __('frontend.privacyPolicy_lastWords') }}
            </p>
        </div>
    </div>
</x-layouts.main>
