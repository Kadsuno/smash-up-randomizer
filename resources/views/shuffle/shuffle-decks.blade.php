<x-layouts.main>
    <div id="hero-header" class="flex min-h-screen flex-col">
        <div class="relative w-full flex-1 overflow-hidden">
            <div class="bg-options min-h-screen" id="hero-js" style="background-image: url('{{ asset('images/result.png') }}'); background-position: center; background-size: cover;">
                <div class="mx-auto max-w-7xl px-4 py-12 pt-24 sm:px-6">
                    <h1 class="mb-10 text-center text-3xl font-bold text-white drop-shadow-lg animate__animated animate__fadeInDown sm:text-4xl">{{ __('frontend.shuffle_results') }}</h1>
                    <div class="grid gap-6 md:grid-cols-2">
                        @foreach ($selectedDecks as $playerDecks)
                        <div class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                            <div class="sur-card overflow-hidden border-cyan-500/20 p-0">
                                <div class="bg-linear-to-r from-cyan-700 to-cyan-600 px-4 py-3 text-center">
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
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-12 text-center">
                        <a href="{{ route('home') }}" class="sur-btn-primary inline-flex min-h-12 animate__animated animate__pulse animate__infinite">{{ __('frontend.shuffle_again') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
