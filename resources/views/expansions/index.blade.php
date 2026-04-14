<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-indigo-950/50 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-5%,rgb(99_102_241_/_0.10),transparent)]" aria-hidden="true"></div>
        <x-sur.container>
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">{{ __('frontend.expansions_hero_eyebrow') }}</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    {{ __('frontend.expansions_hero_title') }}
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-zinc-500">
                    {!! __('frontend.expansions_hero_sub', ['count' => '<strong class="font-semibold text-zinc-300">' . $expansions->count() . '</strong>']) !!}
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Grid --}}
    <x-sur.section>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($expansions as $expansion)
            <x-sur.reveal :delay="($loop->index % 6) * 30">
                <a
                    href="{{ route('expansion', ['slug' => $expansion['slug']]) }}"
                    class="group flex h-full flex-col overflow-hidden rounded-2xl border border-white/8 bg-zinc-900/60 transition duration-200 hover:border-indigo-500/30 hover:bg-zinc-800/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                >
                    {{-- Preview thumbnails — 2×2 grid --}}
                    @php $preview = $expansion['preview']; @endphp
                    @if($preview->isEmpty())
                        <div class="flex h-44 items-center justify-center bg-zinc-800/40">
                            <i class="fa-solid fa-box-open text-3xl text-zinc-700" aria-hidden="true"></i>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-0.5 overflow-hidden">
                            @for($i = 0; $i < 4; $i++)
                                <div class="h-24 overflow-hidden">
                                    @if(isset($preview[$i]))
                                        <img
                                            src="{{ asset($preview[$i]->image) }}"
                                            alt="{{ $preview[$i]->name }}"
                                            class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="h-full bg-zinc-800/30"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="flex flex-1 items-center justify-between gap-3 p-4">
                        <div>
                            <h2 class="text-sm font-bold leading-tight text-white transition group-hover:text-indigo-300">
                                {{ $expansion['name'] }}
                            </h2>
                            <p class="mt-0.5 text-xs text-zinc-600">
                                {{ __('frontend.expansions_factions_label', ['count' => $expansion['count']]) }}
                            </p>
                        </div>
                        <span class="shrink-0 text-xs font-semibold text-indigo-500 transition group-hover:text-indigo-400">
                            <i class="fa-solid fa-arrow-right text-[0.6rem]" aria-hidden="true"></i>
                        </span>
                    </div>
                </a>
            </x-sur.reveal>
            @endforeach
        </div>

        {{-- Back to factions --}}
        <x-sur.reveal>
            <div class="mt-10 border-t border-white/6 pt-6">
                <a href="{{ route('factionList') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-200">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.nav_factions') }}
                </a>
            </div>
        </x-sur.reveal>
    </x-sur.section>

</x-layouts.main>
