<x-layouts.main>
    <div class="container-fluid mb-5">
        <div class="row">
            <h1>
                {{ __('frontend.result') }}
            </h1>
        </div>
    </div>
    <div class="container-fluid">
        
            @foreach ($selectedDecks as $playerDecks)
                @if ($loop->first)
                <div class="row mb-3">
                @elseif ($loop->last)
                <div class="row mb-3">
                @else
                <div class="row mb-3">
                @endif
                    @foreach ($playerDecks as $playerDeck)
                        @if ($loop->odd)
                            <div class="text-center">
                                <h2>
                                    {{ $loop->parent->iteration }}. {{ __('frontend.player') }}
                                </h2>
                            </div>
                        @endif
                        @if ($loop->first)
                            <div class="text-center">
                        @endif
                        <div class="col">
                            <span class="badge badge-lg rounded-pill bg-primary">
                                {{ $playerDeck['name'] }}
                            </span>
                        </div>
                        @if ($loop->last)
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
    </div>
</x-layouts.main>