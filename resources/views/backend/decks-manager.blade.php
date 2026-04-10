<x-layouts.backend.backendMain>

@php
    $total      = $decks->count();
    $withTeaser = $decks->filter(fn($d) => !empty($d->teaser))->count();
    $withDesc   = $decks->filter(fn($d) => !empty($d->description))->count();
    $complete   = $decks->filter(fn($d) => !empty($d->teaser) && !empty($d->description))->count();
    $missing    = $decks->filter(fn($d) => empty($d->teaser) && empty($d->description))->count();
@endphp

{{-- Page header --}}
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white">{{ __('backend.nav_faction_manager') }}</h1>
        <p class="mt-1 text-sm text-zinc-500">
            {{ $total }} factions · {{ $complete }} complete · {{ $missing }} missing all content
        </p>
    </div>
    <a href="{{ route('add-deck') }}"
        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.98]">
        <i class="fas fa-plus text-xs" aria-hidden="true"></i>
        {{ __('backend.add_decks') }}
    </a>
</div>

{{-- Content status strip --}}
<div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
    @php
        $pills = [
            ['label' => 'Total',          'value' => $total,      'color' => 'text-zinc-300',   'dot' => 'bg-zinc-500'],
            ['label' => 'With teaser',    'value' => $withTeaser, 'color' => 'text-violet-300',  'dot' => 'bg-violet-500'],
            ['label' => 'With description','value' => $withDesc,  'color' => 'text-sky-300',     'dot' => 'bg-sky-500'],
            ['label' => 'Missing all',    'value' => $missing,    'color' => 'text-amber-300',   'dot' => 'bg-amber-500'],
        ];
    @endphp
    @foreach($pills as $pill)
    <div class="flex items-center gap-3 rounded-xl border border-white/6 bg-zinc-900/60 px-4 py-3">
        <span class="h-2 w-2 shrink-0 rounded-full {{ $pill['dot'] }}"></span>
        <div class="min-w-0">
            <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">{{ $pill['label'] }}</p>
            <p class="text-lg font-extrabold {{ $pill['color'] }}">{{ $pill['value'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Search + filter + table --}}
<div
    x-data="{
        search: '',
        filter: 'all',
        visibleCount: {{ $total }},
        updateCount() {
            this.$nextTick(() => {
                this.visibleCount = this.$el.querySelectorAll('tr[data-row]:not([style*=\'display: none\'])').length;
            });
        },
        matchRow(name, hasTeaser, hasDesc) {
            const q = this.search.trim().toLowerCase();
            const matchSearch = !q || name.toLowerCase().includes(q);
            const matchFilter =
                this.filter === 'all'          ? true  :
                this.filter === 'missing'      ? (!hasTeaser && !hasDesc) :
                this.filter === 'has_teaser'   ? hasTeaser  :
                this.filter === 'has_desc'     ? hasDesc    : true;
            return matchSearch && matchFilter;
        }
    }"
    @input.debounce.150ms="updateCount"
    @change="updateCount"
>

    {{-- Toolbar --}}
    <div class="mb-3 flex flex-wrap items-center gap-3">

        {{-- Search --}}
        <div class="relative flex-1 sm:max-w-xs">
            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-zinc-600" aria-hidden="true"></i>
            <input
                x-model="search"
                type="text"
                placeholder="Search factions…"
                class="w-full rounded-xl border border-white/8 bg-zinc-900/60 py-2 pl-9 pr-4 text-sm text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-indigo-500/40 focus:ring-2 focus:ring-indigo-500/15"
            >
        </div>

        {{-- Filter --}}
        <select
            x-model="filter"
            class="rounded-xl border border-white/8 bg-zinc-900/60 px-3 py-2 text-sm text-zinc-300 outline-none transition focus:border-indigo-500/40 focus:ring-2 focus:ring-indigo-500/15 cursor-pointer"
        >
            <option value="all">All factions</option>
            <option value="missing">Missing all content</option>
            <option value="has_teaser">Has teaser</option>
            <option value="has_desc">Has description</option>
        </select>

        {{-- Count --}}
        <span class="ml-auto text-xs text-zinc-600" x-text="`${visibleCount} of {{ $total }}`"></span>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[28rem] text-left text-sm">
                <thead>
                    <tr class="border-b border-white/6">
                        <th class="px-4 py-3 text-xs font-bold uppercase tracking-wide text-zinc-600">Faction</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-zinc-600">Teaser</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-zinc-600">Description</th>
                        <th class="px-4 py-3 text-end text-xs font-bold uppercase tracking-wide text-zinc-600">{{ __('backend.table_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @foreach ($decks as $deck)
                    @php
                        $hasTeaser = !empty($deck->teaser);
                        $hasDesc   = !empty($deck->description);
                        $letter    = strtoupper(substr($deck->name, 0, 1));
                        $avatarColors = ['bg-indigo-600','bg-violet-600','bg-sky-600','bg-emerald-600','bg-rose-600','bg-amber-600','bg-teal-600','bg-fuchsia-600'];
                        $avatarBg    = $avatarColors[abs(crc32($deck->name)) % count($avatarColors)];
                    @endphp
                    <tr
                        data-row
                        x-show="matchRow('{{ addslashes(strtolower($deck->name)) }}', {{ $hasTeaser ? 'true' : 'false' }}, {{ $hasDesc ? 'true' : 'false' }})"
                        class="transition hover:bg-white/[0.02]"
                    >
                        {{-- Name --}}
                        <td class="px-4 py-2.5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $avatarBg }} text-xs font-extrabold text-white select-none">
                                    {{ $letter }}
                                </span>
                                <span class="font-semibold text-zinc-100 leading-tight">{{ $deck->name }}</span>
                            </div>
                        </td>

                        {{-- Teaser status --}}
                        <td class="px-4 py-2.5 text-center">
                            @if($hasTeaser)
                                <i class="fa-solid fa-circle-check text-emerald-500" aria-label="Has teaser"></i>
                            @else
                                <i class="fa-solid fa-circle-xmark text-zinc-700" aria-label="No teaser"></i>
                            @endif
                        </td>

                        {{-- Description status --}}
                        <td class="px-4 py-2.5 text-center">
                            @if($hasDesc)
                                <i class="fa-solid fa-circle-check text-emerald-500" aria-label="Has description"></i>
                            @else
                                <i class="fa-solid fa-circle-xmark text-zinc-700" aria-label="No description"></i>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-2.5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('edit-deck', $deck->name) }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-white/8 text-zinc-400 transition hover:border-indigo-500/40 hover:bg-indigo-500/10 hover:text-indigo-300"
                                    title="{{ __('backend.edit_deck') }}">
                                    <i class="fas fa-pencil text-[0.65rem]" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('delete-decks', $deck->name) }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-white/8 text-zinc-600 transition hover:border-red-500/40 hover:bg-red-500/10 hover:text-red-400"
                                    title="{{ __('backend.delete_decks') }}"
                                    onclick="return confirm('{{ __('backend.confirm_delete') }}')">
                                    <i class="fas fa-trash-alt text-[0.65rem]" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Empty state --}}
        <div
            x-show="visibleCount === 0"
            class="flex flex-col items-center gap-3 px-6 py-14 text-center"
            style="display: none;"
        >
            <i class="fa-solid fa-magnifying-glass text-2xl text-zinc-700" aria-hidden="true"></i>
            <p class="text-sm font-semibold text-zinc-500">No factions match your search.</p>
            <button type="button" @click="search = ''; filter = 'all'; updateCount();" class="text-xs text-indigo-400 hover:text-indigo-300 transition">Clear filters</button>
        </div>
    </div>
</div>

{{-- CSV import (collapsible) --}}
<div class="mt-6" x-data="{ open: false }">
    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-zinc-600 transition hover:text-zinc-400"
    >
        <i class="fa-solid fa-chevron-right text-[0.55rem] transition-transform duration-150" :class="open ? 'rotate-90' : ''" aria-hidden="true"></i>
        CSV Import
    </button>
    <div x-show="open" x-transition class="mt-3 rounded-xl border border-white/6 bg-zinc-900/60 p-4" style="display: none;">
        <p class="mb-3 text-xs text-zinc-500">{{ __('backend.headline_csv') }}</p>
        <form action="{{ route('add-deck-csv') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3">
            @csrf
            <label class="sr-only" for="csv-import">{{ __('backend.headline_csv') }}</label>
            <input type="file" id="csv-import" name="csv" accept=".csv" required
                class="block cursor-pointer rounded-xl border border-white/8 bg-zinc-800/60 px-3 py-2 text-sm text-zinc-300
                       file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-500">
            <button class="inline-flex items-center gap-2 rounded-xl border border-white/8 bg-zinc-800/60 px-4 py-2 text-sm font-semibold text-zinc-300 transition hover:border-white/20 hover:text-white" type="submit">
                <i class="fas fa-upload text-xs" aria-hidden="true"></i>
                {{ __('backend.upload') }}
            </button>
        </form>
    </div>
</div>

</x-layouts.backend.backendMain>
