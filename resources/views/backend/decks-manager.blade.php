<x-layouts.backend.backendMain>
    <div class="container-fluid">
        <div class="row no-gutters">
            <h1>
                Decks Manager
            </h1>
            <hr>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters">
            <h2>
                Aktuelle Decks
            </h2>
            <ol class="list-group list-group-numbered">
                @foreach ($decks as $deck)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                        <div class="fw-bold">Deck</div>
                        </div>
                        <a class="btn btn-sm btn-primary rounded-pill" href="#">Delete</a>
                    </li>
                @endforeach
              </ol>
        </div>
    </div>
</x-layouts.backend.backendMain>