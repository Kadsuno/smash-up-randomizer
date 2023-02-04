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
                Current decks
            </h2>
            <ol class="list-group list-group-numbered">
                @foreach ($decks as $deck)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ $deck->name }}</div>
                    </div>
                    <a class="btn btn-sm btn-primary rounded-pill" href="#">Delete</a>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <h2>
                Add new decks
            </h2>
            <div>
                <form method="GET" action="{{ route('decks-manager') }}">
                    <div class="row mb-2">
                        <label for="deckName" class="form-label">Deck name</label>
                        <div class="col-4">
                            <input type="text" class="form-control bg-white" name="deckName">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($deckExists == 1)
        <script>
            window.alert("The deck already exists!");
        </script>
    @endif
</x-layouts.backend.backendMain>