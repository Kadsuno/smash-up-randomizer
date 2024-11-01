<x-layouts.main>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-4 text-center mb-5">About Smash Up Randomizer</h1>
            
            <div class="card bg-dark text-white shadow-lg mb-5">
                <div class="card-body">
                    <h2 class="card-title h4 mb-4">Our Mission</h2>
                    <p class="card-text">
                        Smash Up Randomizer is dedicated to enhancing your Smash Up gaming experience. We aim to provide a quick, fair, and fun way to randomize faction assignments for your games.
                    </p>
                </div>
            </div>

            <div class="card bg-dark text-white shadow-lg mb-5">
                <div class="card-body">
                    <h2 class="card-title h4 mb-4">How It Works</h2>
                    <p class="card-text">
                        Our randomizer uses a sophisticated algorithm to ensure fair and truly random faction assignments. Simply input the number of players and available factions, and let our tool do the rest!
                    </p>
                </div>
            </div>

            <div class="card bg-dark text-white shadow-lg mb-5">
                <div class="card-body">
                    <h2 class="card-title h4 mb-4">Why Choose Us</h2>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Easy to use interface</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Truly random assignments</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Regularly updated faction list</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Free to use</li>
                    </ul>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-light btn-lg">Try It Now</a>
            </div>
        </div>
    </div>
</div>
</x-layouts.main>
