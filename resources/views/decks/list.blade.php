<x-layouts.main>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>Factions</h1>
                <div class="row">
                </div>
                @foreach ($decks as $deck)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $deck->name }}</h5>
                                <p class="card-text">{{ $deck->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.main>
