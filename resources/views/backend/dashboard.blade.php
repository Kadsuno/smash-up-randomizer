<x-layouts.backend.backendMain>

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <p class="mt-1 text-sm text-zinc-500">Overview of the Smash Up Randomizer backend.</p>
    </div>

    {{-- Stats strip --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
        @php
        $stats = [
            ['label' => 'Total factions',    'value' => $total,          'icon' => 'fa-layer-group',  'color' => 'text-indigo-400'],
            ['label' => 'With teaser',        'value' => $withTeaser,     'icon' => 'fa-align-left',   'color' => 'text-violet-400'],
            ['label' => 'With description',   'value' => $withDesc,       'icon' => 'fa-file-lines',   'color' => 'text-sky-400'],
            ['label' => 'Missing details',    'value' => $withoutDetails, 'icon' => 'fa-circle-exclamation', 'color' => 'text-amber-400'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-4">
            <div class="mb-2 flex items-center gap-2">
                <i class="fa-solid {{ $stat['icon'] }} text-sm {{ $stat['color'] }}" aria-hidden="true"></i>
                <span class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $stat['label'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-white">{{ $stat['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Content grid --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Quick actions --}}
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-zinc-400">Quick actions</h2>
            <div class="flex flex-col gap-2">
                <a href="{{ route('add-deck') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-plus w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    Add new faction
                </a>
                <a href="{{ route('decks-manager') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-list w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    Manage all factions
                </a>
                <a href="{{ route('factionList') }}" target="_blank" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    View public faction list
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-globe w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    Open public site
                </a>
            </div>
        </div>

        {{-- Content completeness --}}
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-zinc-400">Content completeness</h2>
            @php
                $bars = [
                    ['label' => 'With teaser',      'value' => $total > 0 ? round($withTeaser / $total * 100) : 0,  'color' => 'bg-violet-500'],
                    ['label' => 'With description', 'value' => $total > 0 ? round($withDesc / $total * 100) : 0,    'color' => 'bg-sky-500'],
                ];
            @endphp
            <div class="flex flex-col gap-4">
                @foreach($bars as $bar)
                <div>
                    <div class="mb-1 flex items-center justify-between text-xs text-zinc-400">
                        <span>{{ $bar['label'] }}</span>
                        <span class="font-semibold text-zinc-300">{{ $bar['value'] }}%</span>
                    </div>
                    <div class="h-2 w-full overflow-hidden rounded-full bg-zinc-800">
                        <div class="h-2 rounded-full {{ $bar['color'] }}" style="width: {{ $bar['value'] }}%"></div>
                    </div>
                </div>
                @endforeach

                @if($withoutDetails > 0)
                <div class="mt-2 flex items-start gap-2 rounded-lg border border-amber-500/20 bg-amber-900/10 px-3 py-2.5 text-xs text-amber-400">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0" aria-hidden="true"></i>
                    <span><strong>{{ $withoutDetails }}</strong> faction{{ $withoutDetails !== 1 ? 's' : '' }} still {{ $withoutDetails !== 1 ? 'have' : 'has' }} no teaser or description. <a href="{{ route('decks-manager') }}" class="underline hover:text-amber-300">Manage factions →</a></span>
                </div>
                @else
                <div class="mt-2 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/10 px-3 py-2.5 text-xs text-emerald-400">
                    <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                    All factions have at least a teaser or description.
                </div>
                @endif
            </div>
        </div>

    </div>

</x-layouts.backend.backendMain>
