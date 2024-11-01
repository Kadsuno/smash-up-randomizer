<x-layouts.main>
    <div class="container mt-5 pt-5">
        <div class="alert alert-info text-center mb-4">
            <strong>Work in Progress</strong> This page is currently under construction. Thank you for your patience.
        </div>
        <h1 class="mb-4 text-center animate__animated animate__fadeInDown">Faction List</h1>
        <div class="row justify-content-center">
            @foreach($decks as $deck)
                @if($deck->teaser)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('factionDetail', ['name' => $deck->name]) }}" class="text-decoration-none">
                        <div class="card bg-dark text-white h-100 shadow-sm hover-card animate__animated animate__fadeIn">
                            @if($deck->image)
                                <img src="{{ asset($deck->image) }}" class="card-img-top img-fluid" alt="{{ $deck->name }}">
                            @else
                                <div class="card-img-top bg-gradient text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span>No Image Available</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $deck->name }}</h5>
                                @if($deck->teaser)
                                    <p class="card-text">{!! $deck->teaser !!}</p>
                                @else
                                    <p class="card-text text-muted fst-italic">No description available.</p>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                
                            </div>
                        </div>
                    </a>
                </div>
                @else
                    
                @endif
            @endforeach
        </div>
    </div>
</x-layouts.main>

<style>
    .hover-card {
        transition: transform 0.3s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
    }
    .animate__animated {
        animation-duration: 1s;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const cards = document.querySelectorAll('.hover-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
