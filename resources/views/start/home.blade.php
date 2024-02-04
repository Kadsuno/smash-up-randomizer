<x-layouts.main>
    <div id="hero-header">
        <div class="position-relative w-100 overflow-hidden hero-height">
            <div class="hero-height bg-options" id="hero-js" style="background-image: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.25)), url('{{ asset('images/smashup_hero.png') }}')">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 pt-5">
                            <div class="my-5 mx-5 text-white bg-transparent px-5 py-5">
                                <h1 class="mb-3">
                                    {{ __('frontend.start_header') }}
                                </h1>
                                <p class="">
                                    {{ __('frontend.start_teaser') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-5 px-5">
        <div class="row">
            <div class="row align-items-md-stretch">
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 bg-success rounded-3 text-white">
                        <h2>
                            {{ __('frontend.help_smashup_header') }}
                        </h2>
                        <p>{{ __('frontend.help_smashup_body') }}</p>
                        <p>{{ __('frontend.help_smashup_function') }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 bg-success text-white rounded-3">
                        <h2>
                            {{ __('frontend.help_howto_header') }}
                        </h2>
                        <p>{{ __('frontend.help_howto_body') }}</p>
                        <p>{{ __('frontend.help_howto_fun') }}</p>
                        <div class="text-center">
                            <a class="btn btn-lg btn-dark text-center" data-bs-toggle="modal" data-bs-target="#shuffle-modal">{{ __('frontend.shuffle_button') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="shuffle-modal" tabindex="-1" aria-labelledby="shuffle-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h5 class="modal-title" id="shuffleModal">{{ __('frontend.shuffle') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" method="GET" action="{{ route('shuffle-result') }}" novalidate>
                    <div class="modal-body">
                        <div class="has-validation">
                            <div class="row">
                                <label for="numberOfPlayers" class="form-label">{{ __('frontend.number_players') }}</label>
                                <div class="col">
                                    <select class="form-select" name="numberOfPlayers">
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    Please choose the number of players.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark"><i class="fa-solid fa-shuffle"></i>
                            {{ __('frontend.shuffle') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>