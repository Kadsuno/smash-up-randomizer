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
                <form>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="deckName" class="form-label">Deck name</label>
                            <input type="text" class="form-control" id="deckName">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">Save</button>    
                        </div>
                    </div>
                  </form>
            </div>
        </div>
    </div>
</x-layouts.backend.backendMain>