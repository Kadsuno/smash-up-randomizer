<x-layouts.backend.backendMain>
    <div class="container-fluid">
        <div class="row">
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
                    @php
                        $idName = str_replace(' ', '', $deck->name);
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $deck->name }}</div>
                        </div>
                        <a class="btn btn-sm btn-primary rounded-pill me-2" href="#" data-bs-toggle="modal"
                            data-bs-target="#{{ $idName }}-modal">{{ __('backend.edit_deck') }}</a>
                        <a class="btn btn-sm btn-primary rounded-pill"
                            href="{{ route('delete-decks', $deck->name) }}">{{ __('backend.delete_decks') }}</a>
                    </li>
                    <!-- Modal -->
                    <div class="modal fade" id="{{ $idName }}-modal" tabindex="-1"
                        aria-labelledby="{{ $deck->name }}-modal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $deck->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form class="needs-validation" method="GET" action="{{ route('edit-deck', $deck->name) }}"
                                    novalidate>
                                    <div class="modal-body">
                                        <div class="row mb-2">
                                            <label for="deckName"
                                                class="form-label">{{ __('backend.deck_name') }}</label>
                                            <div class="col">
                                                <div class="has-validation">
                                                    <input type="text" class="form-control bg-white" name="deckName"
                                                        value="{{ $deck->name }}" required>
                                                    <div class="invalid-feedback">
                                                        {{ __('backend.deck_name_invalid') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                            <button type="submit" class="btn btn-primary">{{ __('backend.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <h2>
                {{ __('backend.headline_csv') }}
            </h2>
            <div>
                <form class="needs-validation" method="POST" action="{{ route('add-deck-csv') }}"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row mb-2">
                        <label for="csv" class="form-label">{{ __('backend.deck_csv') }}</label>
                        <div class="col-4">
                            <div class="has-validation">
                                <input type="file" class="form-control bg-white" name="csv" required>
                                <div class="invalid-feedback">
                                    {{ __('backend.deck_csv_invalid') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">{{ __('backend.upload') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.backend.backendMain>
