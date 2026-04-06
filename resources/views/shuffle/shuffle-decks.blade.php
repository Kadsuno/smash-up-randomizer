<x-layouts.main>
    <div id="hero-header" class="flex min-h-screen flex-col">
        <x-sur.hero :image="asset('images/result.png')" bg-id="hero-js" min-class="min-h-screen">
            <div class="mx-auto w-full max-w-7xl py-12 pt-24">
                <x-sur.reveal>
                    <h1 class="mb-10 text-center text-3xl font-bold text-white drop-shadow-lg sm:text-4xl">{{ __('frontend.shuffle_results') }}</h1>
                </x-sur.reveal>
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($selectedDecks as $playerDecks)
                    <x-sur.reveal :delay="$loop->index * 70">
                        <div class="sur-card overflow-hidden border-indigo-500/20 p-0">
                            <div class="bg-linear-to-r from-indigo-700 via-indigo-600 to-violet-600 px-4 py-3 text-center">
                                <h2 class="text-lg font-bold text-white">
                                    {{ __('frontend.player') }} {{ $loop->iteration }}
                                </h2>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach ($playerDecks as $deck)
                                    <div class="rounded-full border border-white/10 bg-zinc-100 px-3 py-2 text-center text-sm font-semibold text-zinc-900">
                                        <span>{{ $deck['name'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </x-sur.reveal>
                    @endforeach
                </div>
                <div class="mt-12 text-center">
                    <a href="{{ route('home') }}" class="sur-btn-primary inline-flex min-h-12 transition-transform hover:scale-[1.02] active:scale-[0.98]">{{ __('frontend.shuffle_again') }}</a>
                </div>
            </div>
        </x-sur.hero>
    </div>
</x-layouts.main>
