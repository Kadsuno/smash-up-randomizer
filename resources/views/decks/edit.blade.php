<x-layouts.backend.backendMain>
    <div class="mx-auto max-w-4xl">

        <div class="mb-6">
            <div class="mb-1 text-xs text-zinc-600">
                <a href="{{ route('decks-manager') }}" class="hover:text-zinc-400">Faction Manager</a>
                <span class="mx-1">/</span>
                <span>Edit: {{ $deck->name }}</span>
            </div>
            <h1 class="text-2xl font-bold text-white">Edit Faction</h1>
        </div>

        @include('decks._form', [
            'deck'        => $deck,
            'formAction'  => route('update-deck', $deck->name),
            'submitLabel' => 'Update Faction',
        ])

    </div>
</x-layouts.backend.backendMain>
