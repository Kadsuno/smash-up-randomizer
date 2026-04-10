<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-zinc-900 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-5%,rgb(99_102_241_/_0.07),transparent)]" aria-hidden="true"></div>
        <x-sur.container :narrow="true">
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-zinc-500">Legal</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    {{ __('frontend.imprint_header') }}
                </h1>
                <p class="mt-3 text-sm text-zinc-500">
                    Legal information pursuant to § 5 TMG (German Telemedia Act)
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Provider info + Disclaimer --}}
    <x-sur.section :narrow="true">

        {{-- Provider block --}}
        <x-sur.reveal>
            <div class="sur-card mb-8 border-white/8 p-6 sm:p-8">
                <div class="grid gap-8 sm:grid-cols-3">

                    {{-- Address --}}
                    <div>
                        <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">
                            {{ __('frontend.imprint_tmg') }}
                        </p>
                        <address class="not-italic text-sm leading-relaxed text-zinc-300">
                            Mike Rauch<br>
                            Im Turmswinkel 12<br>
                            38122 Braunschweig
                        </address>
                    </div>

                    {{-- Represented by --}}
                    <div>
                        <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">
                            {{ __('frontend.imprint_represent') }}
                        </p>
                        <p class="text-sm text-zinc-300">Mike Rauch</p>
                    </div>

                    {{-- Contact --}}
                    <div>
                        <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">
                            {{ __('frontend.imprint_contact') }}
                        </p>
                        <ul class="flex flex-col gap-2 text-sm">
                            <li class="flex items-center gap-2 text-zinc-300">
                                <i class="fa-solid fa-phone w-4 shrink-0 text-center text-zinc-600" aria-hidden="true"></i>
                                <span>0531-21939351</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-regular fa-envelope w-4 shrink-0 text-center text-zinc-600" aria-hidden="true"></i>
                                <a href="mailto:info@smash-up-randomizer.com" class="text-indigo-400 transition hover:text-indigo-300">
                                    info@smash-up-randomizer.com
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </x-sur.reveal>

        {{-- Disclaimer accordion --}}
        <x-sur.reveal :delay="60">
            <p class="mb-4 text-xs font-bold uppercase tracking-widest text-zinc-500">
                {{ __('frontend.imprint_disclaimer') }}
            </p>

            <div class="flex flex-col gap-2" x-data="{ open: null }">

                @foreach([
                    ['key' => 1, 'header' => __('frontend.imprint_content_header'),   'body' => [__('frontend.imprint_content_body')]],
                    ['key' => 2, 'header' => __('frontend.imprint_copyright_header'), 'body' => [__('frontend.imprint_copyright_body')]],
                    ['key' => 3, 'header' => __('frontend.imprint_data_header'),      'body' => [
                        __('frontend.imprint_data_body_1'),
                        __('frontend.imprint_data_body_2'),
                        __('frontend.imprint_data_body_3'),
                    ]],
                ] as $item)
                <div class="overflow-hidden rounded-xl border border-white/8 bg-zinc-900/60">
                    <button
                        type="button"
                        class="flex w-full items-center justify-between gap-3 px-5 py-4 text-left text-sm font-semibold text-white transition duration-150 hover:bg-white/[0.03]"
                        @click="open = open === {{ $item['key'] }} ? null : {{ $item['key'] }}"
                        :aria-expanded="(open === {{ $item['key'] }}).toString()"
                    >
                        <span>{{ $item['header'] }}</span>
                        <i class="fa-solid fa-chevron-down shrink-0 text-xs text-zinc-500 transition-transform duration-200"
                           :class="open === {{ $item['key'] }} ? 'rotate-180' : ''"
                           aria-hidden="true"></i>
                    </button>
                    <div
                        x-show="open === {{ $item['key'] }}"
                        x-collapse
                        class="border-t border-white/6"
                    >
                        <div class="flex flex-col gap-3 px-5 py-4 text-sm leading-relaxed text-zinc-400">
                            @foreach($item['body'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </x-sur.reveal>

    </x-sur.section>

</x-layouts.main>
