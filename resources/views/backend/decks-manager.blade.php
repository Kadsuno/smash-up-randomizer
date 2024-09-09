<x-layouts.backend.backendMain>
    <div class="container-fluid text-white">
        <div class="container-fluid">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif
                <h1>
                    Faction Manager
                </h1>
                <hr>
            </div>
        </div>
        <div class="container-fluid mb-3">
            <div class="row">
                <h2>
                    Factions
                </h2>
                <ul class="nav nav-tabs" id="factionTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add"
                            type="button" role="tab" aria-controls="add" aria-selected="true"><i
                                class="fa-solid fa-plus"></i> Adding new Factions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="current-tab" data-bs-toggle="tab" data-bs-target="#current"
                            type="button" role="tab" aria-controls="current" aria-selected="false"><i
                                class="fa-solid fa-pen-to-square"></i> Current
                            Factions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="csv-tab" data-bs-toggle="tab" data-bs-target="#csv"
                            type="button" role="tab" aria-controls="csv" aria-selected="false"><i
                                class="fa-solid fa-arrow-up-from-bracket"></i> Import Factions via
                            CSV</button>
                    </li>
                </ul>
                <div class="tab-content" id="factionContent">
                    <div class="tab-pane fade show active border-none text-center" id="add" role="tabpanel"
                        aria-labelledby="add-tab">
                        <a class="text-decoration-none btn btn-success mt-3" href="#" data-bs-toggle="modal"
                            data-bs-target="#add-faction">
                            <i class="fa-solid fa-plus"></i> {{ __('backend.add_decks') }}
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="add-faction" tabindex="-1" aria-labelledby="add-faction"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-black">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addFactionLabel">{{ __('backend.add_decks') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form class="needs-validation" method="POST" action="{{ route('add-deck') }}"
                                        novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <div class="has-validation">
                                                        <label for="name" class="form-label">Faction Name</label>
                                                        <input type="text" class="form-control mb-3" name="name"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="teaser" class="form-label">Faction
                                                            Teaser</label>
                                                        <input type="text" class="form-control mb-3" name="teaser"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="description" class="form-label">Faction
                                                            Description</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="description" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="cardsTeaser" class="form-label">Teaser for Cards
                                                            Section</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="cardsTeaser" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="actionTeaser" class="form-label">Teaser for Action
                                                            List</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="actionTeaser" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="actionList" class="form-label">Short List of
                                                            Actions</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="actionList" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="actions" class="form-label">Faction
                                                            Actions</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="actions" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="characters" class="form-label">Faction
                                                            Characters</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="characters" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="bases" class="form-label">Faction
                                                            Bases</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="bases" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="clarifications" class="form-label">Faction
                                                            Clarifications</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="clarifications" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=col-6>
                                                    <div class="has-validation">
                                                        <label for="suggestionTeaser" class="form-label">Teaser for
                                                            Suggestion Section</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="suggestionTeaser" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="synergy" class="form-label">Faction
                                                            Synergy</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="synergy" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="tips" class="form-label">Faction Tips</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="tips" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="mechanics" class="form-label">Faction
                                                            Mechanics</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="mechanics" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="expansion" class="form-label">Faction
                                                            Expansion</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="expansion" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="effects" class="form-label">Faction
                                                            Effects</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="effects" required>
                                                        <div class="invalid-feedback">
                                                            {{ __('backend.deck_name_invalid') }}
                                                        </div>
                                                    </div>
                                                    <div class="has-validation">
                                                        <label for="playstyle" class="form-label">Faction
                                                            Playstyle</label>
                                                        <input type="text" class="form-control mb-3"
                                                            name="playstyle" required>
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
                                            <button type="submit" class="btn btn-success">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane border-none fade" id="current" role="tabpanel"
                        aria-labelledby="current-tab">
                        <ol class="list-group mt-3">
                            @foreach ($decks as $deck)
                                @php
                                    $idName = str_replace(' ', '', $deck->name);
                                @endphp
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-start bg-success text-white">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <a class="text-decoration-none" href="#" data-bs-toggle="modal"
                                                data-bs-target="#{{ $idName }}-modal">
                                                {{ $deck->name }}
                                            </a>
                                        </div>
                                    </div>
                                    <a class="btn btn-sm btn-dark rounded-pill me-2" href="#"
                                        data-bs-toggle="modal" data-bs-target="#{{ $idName }}-modal">
                                        <i class="fa-solid fa-pen-to-square"></i> {{ __('backend.edit_deck') }}
                                    </a>
                                    <a class="btn btn-sm btn-danger rounded-pill"
                                        href="{{ route('delete-decks', $deck->id) }}">
                                        <i class="fa-solid fa-trash-can"></i> {{ __('backend.delete_decks') }}
                                    </a>
                                </li>
                                <!-- Modal -->
                                <div class="modal fade" id="{{ $idName }}-modal" tabindex="-1"
                                    aria-labelledby="{{ $deck->name }}-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-black">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="currentFactionLabel">
                                                    Edit Faction - {{ $deck->name }} - ID: {{ $deck->id }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form class="needs-validation" method="POST"
                                                action="{{ route('edit-deck', $deck->name) }}" novalidate>
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row mb-2">
                                                        <div class="col-6">
                                                            <div class="has-validation">
                                                                <label for="name" class="form-label">Faction
                                                                    Name</label>
                                                                <input type="text" value="{{ $deck->name }}"
                                                                    class="form-control mb-3" name="name" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="teaser" class="form-label">Faction
                                                                    Teaser</label>
                                                                <input type="text" value="{{ $deck->teaser }}"
                                                                    class="form-control mb-3" name="teaser" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="description" class="form-label">Faction
                                                                    Description</label>
                                                                <input type="text"
                                                                    value="{{ $deck->description }}"
                                                                    class="form-control mb-3" name="description"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="cardsTeaser" class="form-label">Teaser for
                                                                    Cards Section</label>
                                                                <input type="text"
                                                                    value="{{ $deck->cardsTeaser }}"
                                                                    class="form-control mb-3" name="cardsTeaser"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="actionTeaser" class="form-label">Teaser
                                                                    for Action List</label>
                                                                <input type="text"
                                                                    value="{{ $deck->actionTeaser }}"
                                                                    class="form-control mb-3" name="actionTeaser"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="actionList" class="form-label">Short List
                                                                    of Actions</label>
                                                                <input type="text" value="{{ $deck->actionList }}"
                                                                    class="form-control mb-3" name="actionList"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="actions" class="form-label">Faction
                                                                    Actions</label>
                                                                <input type="text" value="{{ $deck->actions }}"
                                                                    class="form-control mb-3" name="actions" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="characters" class="form-label">Faction
                                                                    Characters</label>
                                                                <input type="text" value="{{ $deck->characters }}"
                                                                    class="form-control mb-3" name="characters"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="bases" class="form-label">Faction
                                                                    Bases</label>
                                                                <input type="text" value="{{ $deck->bases }}"
                                                                    class="form-control mb-3" name="bases" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="clarifications" class="form-label">Faction
                                                                    Clarifications</label>
                                                                <input type="text"
                                                                    value="{{ $deck->clarifications }}"
                                                                    class="form-control mb-3" name="clarifications"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=col-6>
                                                            <div class="has-validation">
                                                                <label for="suggestionTeaser"
                                                                    class="form-label">Teaser
                                                                    for
                                                                    Suggestion Section</label>
                                                                <input type="text"
                                                                    value="{{ $deck->suggestionTeaser }}"
                                                                    class="form-control mb-3" name="suggestionTeaser"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="synergy" class="form-label">Faction
                                                                    Synergy</label>
                                                                <input type="text" value="{{ $deck->synergy }}"
                                                                    class="form-control mb-3" name="synergy" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="tips" class="form-label">Faction
                                                                    Tips</label>
                                                                <input type="text" value="{{ $deck->tips }}"
                                                                    class="form-control mb-3" name="tips" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="mechanics" class="form-label">Faction
                                                                    Mechanics</label>
                                                                <input type="text" value="{{ $deck->mechanics }}"
                                                                    class="form-control mb-3" name="mechanics"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="expansion" class="form-label">Faction
                                                                    Expansion</label>
                                                                <input type="text" value="{{ $deck->expansion }}"
                                                                    class="form-control mb-3" name="expansion"
                                                                    required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="effects" class="form-label">Faction
                                                                    Effects</label>
                                                                <input type="text" value="{{ $deck->effects }}"
                                                                    class="form-control mb-3" name="effects" required>
                                                                <div class="invalid-feedback">
                                                                    {{ __('backend.deck_name_invalid') }}
                                                                </div>
                                                            </div>
                                                            <div class="has-validation">
                                                                <label for="playstyle" class="form-label">Faction
                                                                    Playstyle</label>
                                                                <input type="text" value="{{ $deck->playstyle }}"
                                                                    class="form-control mb-3" name="playstyle"
                                                                    required>
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
                                                    <button type="submit" class="btn btn-success">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ol>
                    </div>
                    <div class="tab-pane border-none fade" id="csv" role="tabpanel" aria-labelledby="csv-tab">
                        <div class="mt-3">
                            <form class="needs-validation" method="POST" action="{{ route('add-deck-csv') }}"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row mb-2">
                                    <label for="csv" class="form-label">{{ __('backend.deck_csv') }}</label>
                                    <div class="col-4">
                                        <div class="has-validation">
                                            <input type="file" class="form-control" name="csv" required>
                                            <div class="invalid-feedback">
                                                {{ __('backend.deck_csv_invalid') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit"
                                            class="btn btn-success">{{ __('backend.upload') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.backend.backendMain>
