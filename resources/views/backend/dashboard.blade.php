<x-layouts.backend.backendMain>

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">{{ __('backend.dashboard_title') }}</h1>
        <p class="mt-1 text-sm text-zinc-500">{{ __('backend.dashboard_tagline') }}</p>
    </div>

    {{-- Stats strip --}}
    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-4">
        @php
        $stats = [
            ['label' => __('backend.stat_total_factions'),    'value' => $total,          'icon' => 'fa-layer-group',  'color' => 'text-indigo-400'],
            ['label' => __('backend.stat_with_teaser'),        'value' => $withTeaser,     'icon' => 'fa-align-left',   'color' => 'text-violet-400'],
            ['label' => __('backend.stat_with_description'),   'value' => $withDesc,       'icon' => 'fa-file-lines',   'color' => 'text-sky-400'],
            ['label' => __('backend.stat_missing_details'),    'value' => $withoutDetails, 'icon' => 'fa-circle-exclamation', 'color' => 'text-amber-400'],
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

    <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-4">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('backend.stat_contact_messages') }}</div>
            <p class="text-2xl font-extrabold text-white">{{ $contactsTotal }}</p>
        </div>
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-4">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('backend.stat_registered_users') }}</div>
            <p class="text-2xl font-extrabold text-white">{{ $usersTotal }} <span class="text-sm font-normal text-zinc-500">({{ __('backend.stat_admins_count', ['count' => $adminsTotal]) }})</span></p>
        </div>
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-4">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('backend.stat_shuffle_runs') }}</div>
            <p class="text-2xl font-extrabold text-white">{{ $shuffleTotal }}</p>
        </div>
    </div>

    @if($shuffleTotal > 0 && count($shuffleByPlayers) > 0)
    <div class="mb-8 rounded-xl border border-white/8 bg-zinc-900/60 p-4">
        <h2 class="mb-3 text-xs font-bold uppercase tracking-wide text-zinc-400">{{ __('backend.shuffle_by_players') }}</h2>
        <div class="flex flex-wrap gap-3">
            @foreach($shuffleByPlayers as $players => $cnt)
                <span class="rounded-lg border border-white/6 bg-zinc-800/60 px-3 py-1.5 text-sm text-zinc-300">
                    {{ __('backend.shuffle_bucket', ['players' => $players, 'count' => $cnt]) }}
                </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Content grid --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Quick actions --}}
        <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-6">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-zinc-400">{{ __('backend.dashboard_quick_actions') }}</h2>
            <div class="flex flex-col gap-2">
                <a href="{{ route('add-deck') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-plus w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.quick_add_faction') }}
                </a>
                <a href="{{ route('decks-manager') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-list w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.quick_manage_factions') }}
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-envelope w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.nav_contacts') }}
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-users w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.nav_users') }}
                </a>
                <a href="{{ route('admin.shuffle-stats') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-shuffle w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.nav_shuffle_stats') }}
                </a>
                <a href="{{ route('admin.maintenance') }}" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-terminal w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.nav_maintenance') }}
                </a>
                <a href="{{ route('factionList') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.quick_public_factions') }}
                </a>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 rounded-lg border border-white/6 bg-zinc-800/60 px-4 py-3 text-sm font-medium text-zinc-200 transition hover:border-indigo-500/30 hover:text-indigo-300">
                    <i class="fa-solid fa-globe w-4 text-center text-indigo-400" aria-hidden="true"></i>
                    {{ __('backend.quick_public_site') }}
                </a>
            </div>
        </div>

        {{-- Content completeness + recent contacts --}}
        <div class="flex flex-col gap-6">
            <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-6">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-zinc-400">{{ __('backend.content_completeness') }}</h2>
                @php
                    $bars = [
                        ['label' => __('backend.stat_with_teaser'),      'value' => $total > 0 ? round($withTeaser / $total * 100) : 0,  'color' => 'bg-violet-500'],
                        ['label' => __('backend.stat_with_description'), 'value' => $total > 0 ? round($withDesc / $total * 100) : 0,    'color' => 'bg-sky-500'],
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
                        <span>{!! __('backend.alert_missing_details', ['count' => $withoutDetails, 'link' => route('decks-manager')]) !!}</span>
                    </div>
                    @else
                    <div class="mt-2 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/10 px-3 py-2.5 text-xs text-emerald-400">
                        <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                        {{ __('backend.all_have_teaser_or_desc') }}
                    </div>
                    @endif
                </div>
            </div>

            @if($recentContacts->isNotEmpty())
            <div class="rounded-xl border border-white/8 bg-zinc-900/60 p-6">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-zinc-400">{{ __('backend.recent_contacts') }}</h2>
                <ul class="flex flex-col gap-2 text-sm">
                    @foreach($recentContacts as $c)
                    <li class="flex items-center justify-between gap-2 border-b border-white/5 pb-2 last:border-0">
                        <span class="truncate text-zinc-300">{{ $c->subject }}</span>
                        <a href="{{ route('admin.contacts.show', $c) }}" class="shrink-0 text-xs text-indigo-400 hover:text-indigo-300">{{ __('backend.view') }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

    </div>

</x-layouts.backend.backendMain>
