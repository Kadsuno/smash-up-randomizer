<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-zinc-900 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-5%,rgb(99_102_241_/_0.07),transparent)]" aria-hidden="true"></div>
        <x-sur.container :narrow="true">
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-zinc-500">Legal</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    {{ __('frontend.privacyPolicy_header') }}
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-zinc-500">
                    This policy explains what data we collect, why, and how you stay in control. Short version: we collect very little, share nothing, and analytics are strictly opt-in.
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Quick-facts strip --}}
    <div class="border-b border-white/6 bg-zinc-900/40">
        <x-sur.container :narrow="true">
            <div class="flex flex-wrap gap-x-6 gap-y-2 py-4">
                @foreach([
                    ['icon' => 'fa-solid fa-ban',          'color' => 'text-emerald-400', 'text' => 'No third-party trackers'],
                    ['icon' => 'fa-solid fa-server',        'color' => 'text-indigo-400',  'text' => 'Self-hosted analytics'],
                    ['icon' => 'fa-solid fa-hand',          'color' => 'text-violet-400',  'text' => 'Analytics opt-in only'],
                    ['icon' => 'fa-solid fa-lock',          'color' => 'text-sky-400',     'text' => 'HTTPS encrypted'],
                    ['icon' => 'fa-solid fa-share-nodes',   'color' => 'text-rose-400',    'text' => 'No data sold or shared'],
                ] as $fact)
                <span class="inline-flex items-center gap-1.5 text-xs text-zinc-400">
                    <i class="{{ $fact['icon'] }} {{ $fact['color'] }} text-[0.6rem]" aria-hidden="true"></i>
                    {{ $fact['text'] }}
                </span>
                @endforeach
            </div>
        </x-sur.container>
    </div>

    {{-- Content --}}
    <x-sur.section :narrow="true">
        <x-sur.reveal>
            <div class="flex flex-col gap-2" x-data="{ open: null }">

                @php
                $sections = [
                    [
                        'key'   => 1,
                        'icon'  => 'fa-solid fa-database',
                        'color' => 'text-zinc-400',
                        'title' => __('frontend.privacyPolicy_dataCollection_header'),
                        'body'  => [__('frontend.privacyPolicy_dataCollection_body')],
                    ],
                    [
                        'key'   => 2,
                        'icon'  => 'fa-solid fa-chart-simple',
                        'color' => 'text-indigo-400',
                        'title' => 'Analytics (Matomo)',
                        'body'  => [
                            __('frontend.privacyPolicy_matomo_body'),
                            __('frontend.privacyPolicy_consent_cookies_body'),
                            __('frontend.privacyPolicy_matomo_dataSharing_body'),
                        ],
                    ],
                    [
                        'key'   => 3,
                        'icon'  => 'fa-solid fa-cookie-bite',
                        'color' => 'text-amber-400',
                        'title' => __('frontend.privacyPolicy_cookies_header'),
                        'body'  => [
                            __('frontend.privacyPolicy_cookies_body'),
                            __('frontend.privacyPolicy_consent_body'),
                        ],
                    ],
                    [
                        'key'   => 4,
                        'icon'  => 'fa-solid fa-lock',
                        'color' => 'text-sky-400',
                        'title' => __('frontend.privacyPolicy_security_header'),
                        'body'  => [__('frontend.privacyPolicy_security_body')],
                    ],
                    [
                        'key'   => 5,
                        'icon'  => 'fa-solid fa-scale-balanced',
                        'color' => 'text-violet-400',
                        'title' => __('frontend.privacyPolicy_rights_header'),
                        'body'  => [__('frontend.privacyPolicy_rights_body')],
                    ],
                    [
                        'key'   => 6,
                        'icon'  => 'fa-solid fa-share-nodes',
                        'color' => 'text-rose-400',
                        'title' => __('frontend.privacyPolicy_dataSharing_header'),
                        'body'  => [__('frontend.privacyPolicy_dataSharing_body')],
                    ],
                ];
                @endphp

                @foreach($sections as $section)
                <div class="overflow-hidden rounded-xl border border-white/8 bg-zinc-900/60">
                    <button
                        type="button"
                        class="flex w-full items-center gap-3 px-5 py-4 text-left text-sm font-semibold text-white transition duration-150 hover:bg-white/[0.03]"
                        @click="open = open === {{ $section['key'] }} ? null : {{ $section['key'] }}"
                        :aria-expanded="(open === {{ $section['key'] }}).toString()"
                    >
                        <i class="{{ $section['icon'] }} {{ $section['color'] }} w-4 shrink-0 text-center text-xs" aria-hidden="true"></i>
                        <span class="flex-1">{{ $section['title'] }}</span>
                        <i class="fa-solid fa-chevron-down shrink-0 text-xs text-zinc-500 transition-transform duration-200"
                           :class="open === {{ $section['key'] }} ? 'rotate-180' : ''"
                           aria-hidden="true"></i>
                    </button>
                    <div
                        x-show="open === {{ $section['key'] }}"
                        x-collapse
                        class="border-t border-white/6"
                    >
                        <div class="flex flex-col gap-3 px-5 py-4 text-sm leading-relaxed text-zinc-400">
                            @foreach($section['body'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            {{-- Contact note --}}
            <p class="mt-8 text-center text-xs leading-relaxed text-zinc-600">
                {{ __('frontend.privacyPolicy_lastWords') }}
                <a href="{{ route('contact') }}" class="text-zinc-500 underline decoration-zinc-700 underline-offset-2 transition hover:text-indigo-400">Contact us</a>.
            </p>
        </x-sur.reveal>
    </x-sur.section>

</x-layouts.main>
