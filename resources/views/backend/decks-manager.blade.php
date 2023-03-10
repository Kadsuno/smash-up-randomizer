<x-layouts.backend.backendMain>
    <div class="container-fluid">
        <div class="row no-gutters">
            <h1>
                Decks Manager
            </h1>
            <hr>
        </div>
    </div>
    <div class="container-fluid mb-5">
        <div class="row">
            <h2>
                {{ __('backend.current_decks') }}
            </h2>
            <ol class="list-group list-group-numbered">
                @foreach ($decks as $deck)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ $deck->name }}</div>
                    </div>
                    <a class="btn btn-sm btn-primary rounded-pill" href="{{ route('delete-decks', $deck->name) }}">{{ __('backend.delete_decks') }}</a>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <h2>
                {{ __('backend.add_decks') }}
            </h2>
            <div>
                <form class="needs-validation" method="GET" action="{{ route('add-deck') }}" novalidate>
                    <div class="row mb-2">
                        <label for="deckName" class="form-label">{{ __('backend.deck_name') }}</label>
                        <div class="col-4">
                            <div class="has-validation">
                                <input type="text" class="form-control bg-white" name="deckName" required>
                                <div class="invalid-feedback">
                                    {{ __('backend.deck_name_invalid') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">{{ __('Speichern') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.backend.backendMain>