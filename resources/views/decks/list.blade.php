<x-layouts.main>
    <x-sur.section :padded="true">
        <div class="mb-6 rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-center text-sm text-amber-100">
            <strong>Work in Progress</strong> — This page is currently under construction. Thank you for your patience.
        </div>
        <x-sur.reveal>
            <x-sur.page-heading class="mb-8">Faction List</x-sur.page-heading>
        </x-sur.reveal>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($decks as $deck)
                @if($deck->teaser)
                <x-sur.reveal :delay="$loop->index * 55">
                    <a href="{{ route('factionDetail', ['name' => $deck->name]) }}" class="group block rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60">
                        <div class="sur-card-interactive h-full overflow-hidden p-0">
                            @if($deck->image)
                                <img src="{{ asset($deck->image) }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-[1.02]" alt="{{ $deck->name }}">
                            @else
                                <div class="flex h-48 items-center justify-center bg-linear-to-br from-zinc-800 to-zinc-900 text-zinc-500">
                                    <span>No Image Available</span>
                                </div>
                            @endif
                            <div class="p-5">
                                <h2 class="mb-2 text-lg font-bold text-white group-hover:text-indigo-300">{{ $deck->name }}</h2>
                                @if($deck->teaser)
                                    <p class="line-clamp-4 text-sm leading-relaxed text-zinc-400">{!! $deck->teaser !!}</p>
                                @else
                                    <p class="text-sm italic text-zinc-500">No description available.</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </x-sur.reveal>
                @endif
            @endforeach
        </div>
    </x-sur.section>
</x-layouts.main>
