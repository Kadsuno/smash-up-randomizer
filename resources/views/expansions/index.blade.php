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
                    {{-- Preview thumbnails — adaptive layout, no empty slots --}}
                    @php $preview = $expansion['preview']; $pc = count($preview); @endphp
                    <div class="h-48 overflow-hidden">
                        @if($pc === 0)
                            <div class="flex h-full items-center justify-center bg-zinc-800/40">
                                <i class="fa-solid fa-box-open text-3xl text-zinc-700" aria-hidden="true"></i>
                            </div>
                        @elseif($pc === 1)
                            <img src="{{ asset($preview[0]->image) }}" alt="{{ $preview[0]->name }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]" loading="lazy">
                        @elseif($pc === 2)
                            <div class="grid h-full grid-cols-2 gap-0.5">
                                @foreach($preview as $f)
                                    <img src="{{ asset($f->image) }}" alt="{{ $f->name }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]" loading="lazy">
                                @endforeach
                            </div>
                        @elseif($pc === 3)
                            <div class="grid h-full grid-cols-2 grid-rows-2 gap-0.5">
                                <img src="{{ asset($preview[0]->image) }}" alt="{{ $preview[0]->name }}"
                                    class="col-span-2 h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]" loading="lazy">
                                <img src="{{ asset($preview[1]->image) }}" alt="{{ $preview[1]->name }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]" loading="lazy">
                                <img src="{{ asset($preview[2]->image) }}" alt="{{ $preview[2]->name }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]" loading="lazy">
                            </div>
                        @else
                            <div class="grid h-full grid-cols-2 grid-rows-2 gap-0.5">
                                @foreach($preview->take(4) as $f)
                                    <img src="{{ asset($f->image) }}" alt="{{ $f->name }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]" loading="lazy">
                                @endforeach
                            </div>
                        @endif
                    </div>

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
