<x-layouts.main>

<div class="mx-auto max-w-3xl px-4 py-16 pt-24 sm:px-6">
    <h1 class="mb-10 text-center text-3xl font-bold text-white sm:text-4xl">About Smash Up Randomizer</h1>

    <div class="sur-card mb-8 border-white/10">
        <h2 class="mb-4 text-lg font-semibold text-indigo-300">Our Mission</h2>
        <p class="leading-relaxed text-zinc-300">
            Smash Up Randomizer is dedicated to enhancing your Smash Up gaming experience. We aim to provide a quick, fair, and fun way to randomize faction assignments for your games.
        </p>
    </div>

    <div class="sur-card mb-8 border-white/10">
        <h2 class="mb-4 text-lg font-semibold text-indigo-300">How It Works</h2>
        <p class="leading-relaxed text-zinc-300">
            Our randomizer uses a sophisticated algorithm to ensure fair and truly random faction assignments. Simply input the number of players and available factions, and let our tool do the rest!
        </p>
    </div>

    <div class="sur-card mb-10 border-white/10">
        <h2 class="mb-4 text-lg font-semibold text-indigo-300">Why Choose Us</h2>
        <ul class="space-y-2 text-zinc-300">
            <li class="flex gap-2"><i class="fas fa-check-circle mt-0.5 text-emerald-400" aria-hidden="true"></i> Easy to use interface</li>
            <li class="flex gap-2"><i class="fas fa-check-circle mt-0.5 text-emerald-400" aria-hidden="true"></i> Truly random assignments</li>
            <li class="flex gap-2"><i class="fas fa-check-circle mt-0.5 text-emerald-400" aria-hidden="true"></i> Regularly updated faction list</li>
            <li class="flex gap-2"><i class="fas fa-check-circle mt-0.5 text-emerald-400" aria-hidden="true"></i> Free to use</li>
        </ul>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="sur-btn-primary min-h-12">Try It Now</a>
    </div>
</div>

</x-layouts.main>
