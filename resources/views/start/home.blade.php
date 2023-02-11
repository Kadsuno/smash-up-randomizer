<x-layouts.main>
      <div class="container-fluid">
            <div class="row mb-5">
                  <h1>
                        {{ __('frontend.start_header') }}
                  </h1>
            </div>
            <div class="row mb-5">
                  <p>
                        {{ __('frontend.start_teaser') }}
                  </p>
            </div>
      </div>
      <div class="container-fluid">
            <div class="row">
                  <form class="needs-validation" method="GET" action="{{ route('shuffle-decks') }}" novalidate>
                        <div class="row mb-2">
                              <label for="numberOfPlayers" class="form-label">{{ __('frontend.number_players') }}</label>
                              <div class="col-4">
                                    <div class="has-validation">
                                          <select class="form-select" name="numberOfPlayers">
                                                <option selected>{{ __('frontend.number_players_choose') }}</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                          </select>                                          
                                          <div class="invalid-feedback">
                                                Please choose the number of players.
                                          </div>
                                    </div>
                              </div>
                              <div class="col-4">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-shuffle"></i> {{ __('frontend.shuffle') }}</button>
                              </div>
                        </div>
                  </form>
            </div>
      </div>
</x-layouts.main>