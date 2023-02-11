<x-layouts.main>
    <div class="container-fluid mb-5">
        <div class="row">
            <h1>
                Ergebnis
            </h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            @foreach ($selectedDecks as $playerDecks)
                @if ($loop->first)
                <div class="col border-right border-white">
                @elseif ($loop->last)
                <div class="col border-left border-white">
                @else
                <div class="col border-left border-right border-white">
                @endif
                    @foreach ($playerDecks as $playerDeck)
                        @if ($loop->odd)
                            <div class="row text-center">
                                <h2>
                                    {{ $loop->parent->iteration }}. {{ __('frontend.player') }}
                                </h2>
                            </div>
                        @endif
                        @if ($loop->first)
                            <div class="row text-center">
                        @endif
                        <div class="col-6">
                            {{ $playerDeck['name'] }}
                        </div>
                        @if ($loop->last)
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.main>