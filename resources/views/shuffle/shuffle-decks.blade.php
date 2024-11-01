<x-layouts.main>
    <div id="hero-header" class="min-vh-100 d-flex">
        <div class="position-relative w-100 overflow-hidden">
            <div class="bg-options" id="hero-js" style="background-image: url('{{ asset('images/result.png') }}'); background-position: center; background-size: cover;">
                <div class="container py-5 mt-5">
                    <h1 class="text-center text-white mb-5 animate__animated animate__fadeInDown">{{ __('frontend.shuffle_results') }}</h1>
                    <div class="row justify-content-center">
                        @foreach ($selectedDecks as $playerDecks)
                        <div class="col-lg-6 mb-4">
                            <div class="card bg-dark text-white shadow-lg animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                                <div class="card-header bg-primary">
                                    <h2 class="text-center mb-0">
                                        {{ __('frontend.player') }} {{ $loop->iteration }}
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($playerDecks as $deck)
                                        <div class="col-6 mb-3">
                                            <div class="bg-light text-dark rounded-pill p-2 text-center">
                                                <span class="fw-bold">{{ $deck['name'] }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-5">
                        <a href="{{ route('home') }}" class="btn btn-lg btn-primary animate__animated animate__pulse animate__infinite">{{ __('frontend.shuffle_again') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>