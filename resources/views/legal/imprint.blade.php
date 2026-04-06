<x-layouts.main>
    <div class="mx-auto max-w-3xl px-4 pb-16 pt-24 sm:px-6">
        <h1 class="mb-10 text-3xl font-bold text-white">
            {{ __('frontend.imprint_header') }}
        </h1>

        <div class="sur-card mb-6 border-white/10">
            <h2 class="mb-3 text-lg font-semibold text-cyan-300">{{ __('frontend.imprint_tmg') }}</h2>
            <p class="leading-relaxed text-zinc-300">
                Mike Rauch <br>
                Im Turmswinkel 12<br>
                38122 Braunschweig <br>
            </p>
        </div>

        <div class="sur-card mb-6 border-white/10">
            <h2 class="mb-3 text-lg font-semibold text-cyan-300">{{ __('frontend.imprint_represent') }}</h2>
            <p class="text-zinc-300">Mike Rauch</p>
        </div>

        <div class="sur-card mb-10 border-white/10">
            <h2 class="mb-3 text-lg font-semibold text-cyan-300">{{ __('frontend.imprint_contact') }}</h2>
            <p class="mb-2 text-zinc-300">
                <i class="fas fa-phone-alt me-2 text-cyan-500" aria-hidden="true"></i>{{ __('frontend.imprint_phone') }}: 0531-21939351
            </p>
            <p class="text-zinc-300">
                <i class="fas fa-envelope me-2 text-cyan-500" aria-hidden="true"></i>{{ __('frontend.imprint_email') }}:
                <a href="mailto:info@smash-up-randomizer.com" class="text-cyan-400 underline decoration-cyan-500/40 underline-offset-2 hover:text-cyan-300">
                    info@smash-up-randomizer.com
                </a>
            </p>
        </div>

        <h2 class="mb-4 text-xl font-bold text-white">{{ __('frontend.imprint_disclaimer') }}</h2>

        <div class="space-y-2" x-data="{ open: 1 }">
            <div class="overflow-hidden rounded-xl border border-white/10">
                <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80"
                    @click="open = open === 1 ? 0 : 1">
                    {{ __('frontend.imprint_content_header') }}
                    <i class="fas fa-chevron-down text-zinc-500 transition" :class="open === 1 && 'rotate-180'"></i>
                </button>
                <div x-show="open === 1" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                    <p>{{ __('frontend.imprint_content_body') }}</p>
                </div>
            </div>
            <div class="overflow-hidden rounded-xl border border-white/10">
                <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80"
                    @click="open = open === 2 ? 0 : 2">
                    {{ __('frontend.imprint_copyright_header') }}
                    <i class="fas fa-chevron-down text-zinc-500 transition" :class="open === 2 && 'rotate-180'"></i>
                </button>
                <div x-show="open === 2" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                    <p>{{ __('frontend.imprint_copyright_body') }}</p>
                </div>
            </div>
            <div class="overflow-hidden rounded-xl border border-white/10">
                <button type="button" class="flex w-full items-center justify-between gap-3 bg-zinc-900/80 px-4 py-4 text-left text-sm font-semibold text-white transition hover:bg-zinc-800/80"
                    @click="open = open === 3 ? 0 : 3">
                    {{ __('frontend.imprint_data_header') }}
                    <i class="fas fa-chevron-down text-zinc-500 transition" :class="open === 3 && 'rotate-180'"></i>
                </button>
                <div x-show="open === 3" x-transition class="border-t border-white/10 bg-zinc-950/60 px-4 py-4 text-sm leading-relaxed text-zinc-300">
                    <p class="mb-3">{{ __('frontend.imprint_data_body_1') }}</p>
                    <p class="mb-3">{{ __('frontend.imprint_data_body_2') }}</p>
                    <p>{{ __('frontend.imprint_data_body_3') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
