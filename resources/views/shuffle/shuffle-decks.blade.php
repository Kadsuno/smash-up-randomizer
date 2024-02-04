<x-layouts.main>
    <div id="hero-header">
        <div class="position-relative w-100 overflow-hidden">
            <div class="bg-options" id="hero-js" style="background-image: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('{{ asset('images/result.png') }}'); background-position: center">
                <div class="container pb-5">
                    <div class="row justify-content-center">
                        @foreach ($selectedDecks as $playerDecks)
                        <div class="col-md-6 mt-5 pt-5">
                            <div class="h-100 py-5 bg-success opacity-90 text-white rounded-3">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h2 class="text-center">
                                            {{ __('frontend.player') }} {{ $loop->iteration }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($playerDecks as $deck)
                                    <div class="col-md-6 text-center">
                                        <span class="">
                                            {{ $deck['name'] }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>