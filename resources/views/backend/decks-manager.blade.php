<x-layouts.backend.backendMain>

@php
    $total      = $deckStats['total'];
    $withTeaser = $deckStats['with_teaser'];
    $withDesc   = $deckStats['with_desc'];
    $complete   = $deckStats['complete'];
    $missing    = $deckStats['missing'];
    $f = $filters;
@endphp

{{-- Page header --}}
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white">{{ __('backend.nav_faction_manager') }}</h1>
        <p class="mt-1 text-sm text-zinc-500">
            {{ __('backend.faction_manager_subtitle', ['total' => $total, 'complete' => $complete, 'missing' => $missing]) }}
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
            ['label' => __('backend.stat_total'),          'value' => $total,      'color' => 'text-zinc-300',   'dot' => 'bg-zinc-500'],
            ['label' => __('backend.stat_with_teaser'),    'value' => $withTeaser, 'color' => 'text-violet-300',  'dot' => 'bg-violet-500'],
            ['label' => __('backend.stat_with_description'),'value' => $withDesc,  'color' => 'text-sky-300',     'dot' => 'bg-sky-500'],
            ['label' => __('backend.stat_missing_all'),    'value' => $missing,    'color' => 'text-amber-300',   'dot' => 'bg-amber-500'],
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

{{-- Filters (server-side) --}}
<form method="GET" action="{{ route('decks-manager') }}" class="mb-3 flex flex-wrap items-center gap-3">
    <div class="relative flex-1 sm:max-w-xs">
        <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-zinc-600" aria-hidden="true"></i>
        <input type="search" name="q" value="{{ $f['q'] }}"
            placeholder="{{ __('backend.search_factions_placeholder') }}"
            class="w-full rounded-xl border border-white/8 bg-zinc-900/60 py-2 pl-9 pr-4 text-sm text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-indigo-500/40 focus:ring-2 focus:ring-indigo-500/15">
    </div>
    <select name="filter"
        class="rounded-xl border border-white/8 bg-zinc-900/60 px-3 py-2 text-sm text-zinc-300 outline-none transition focus:border-indigo-500/40 focus:ring-2 focus:ring-indigo-500/15 cursor-pointer">
        <option value="all" @selected($f['filter'] === 'all')>{{ __('backend.filter_all') }}</option>
        <option value="missing" @selected($f['filter'] === 'missing')>{{ __('backend.filter_missing') }}</option>
        <option value="has_teaser" @selected($f['filter'] === 'has_teaser')>{{ __('backend.filter_has_teaser') }}</option>
        <option value="has_desc" @selected($f['filter'] === 'has_desc')>{{ __('backend.filter_has_desc') }}</option>
    </select>
    <select name="expansion"
        class="rounded-xl border border-white/8 bg-zinc-900/60 px-3 py-2 text-sm text-zinc-300 outline-none transition focus:border-indigo-500/40 focus:ring-2 focus:ring-indigo-500/15 cursor-pointer max-w-[14rem]">
        <option value="">{{ __('backend.filter_all_expansions') }}</option>
        @foreach($expansionOptions as $exp)
            <option value="{{ $exp }}" @selected($f['expansion'] === $exp)>{{ $exp }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-xl border border-white/8 bg-zinc-800/60 px-4 py-2 text-sm font-semibold text-zinc-300 transition hover:border-white/20 hover:text-white">
        {{ __('backend.apply_filters') }}
    </button>
    @if($f['q'] !== '' || $f['filter'] !== 'all' || $f['expansion'] !== '')
        <a href="{{ route('decks-manager') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition">{{ __('backend.clear_filters') }}</a>
    @endif
</form>

<p class="mb-3 text-xs text-zinc-600">{{ __('backend.page_showing', ['from' => $decks->firstItem() ?? 0, 'to' => $decks->lastItem() ?? 0, 'total' => $decks->total()]) }}</p>

{{-- Table --}}
<div class="overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[28rem] text-left text-sm">
            <thead>
                <tr class="border-b border-white/6">
                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wide text-zinc-600">{{ __('backend.table_faction') }}</th>
                    <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-zinc-600">{{ __('backend.table_teaser') }}</th>
                    <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-zinc-600">{{ __('backend.table_description') }}</th>
                    <th class="px-4 py-3 text-end text-xs font-bold uppercase tracking-wide text-zinc-600">{{ __('backend.table_actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.04]">
                @forelse ($decks as $deck)
                @php
                    $hasTeaser = !empty($deck->teaser);
                    $hasDesc   = !empty($deck->description);
                    $letter    = strtoupper(substr($deck->name, 0, 1));
                    $avatarColors = ['bg-indigo-600','bg-violet-600','bg-sky-600','bg-emerald-600','bg-rose-600','bg-amber-600','bg-teal-600','bg-fuchsia-600'];
                    $avatarBg    = $avatarColors[abs(crc32($deck->name)) % count($avatarColors)];
                @endphp
                <tr class="transition hover:bg-white/[0.02]">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $avatarBg }} text-xs font-extrabold text-white select-none">
                                {{ $letter }}
                            </span>
                            <span class="font-semibold text-zinc-100 leading-tight">{{ $deck->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        @if($hasTeaser)
                            <i class="fa-solid fa-circle-check text-emerald-500" aria-label="{{ __('backend.has_teaser_aria') }}"></i>
                        @else
                            <i class="fa-solid fa-circle-xmark text-zinc-700" aria-label="{{ __('backend.no_teaser_aria') }}"></i>
                        @endif
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        @if($hasDesc)
                            <i class="fa-solid fa-circle-check text-emerald-500" aria-label="{{ __('backend.has_description_aria') }}"></i>
                        @else
                            <i class="fa-solid fa-circle-xmark text-zinc-700" aria-label="{{ __('backend.no_description_aria') }}"></i>
                        @endif
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('edit-deck', ['name' => $deck->name]) }}"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-white/8 text-zinc-400 transition hover:border-indigo-500/40 hover:bg-indigo-500/10 hover:text-indigo-300"
                                title="{{ __('backend.edit_deck') }}">
                                <i class="fas fa-pencil text-[0.65rem]" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('delete-decks', ['name' => $deck->name]) }}" method="POST" class="inline"
                                onsubmit="return confirm(@json(__('backend.confirm_delete')))">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg border border-white/8 text-zinc-600 transition hover:border-red-500/40 hover:bg-red-500/10 hover:text-red-400"
                                    title="{{ __('backend.delete_decks') }}">
                                    <i class="fas fa-trash-alt text-[0.65rem]" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center text-sm text-zinc-500">{{ __('backend.no_factions') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $decks->links() }}
</div>

{{-- CSV import (collapsible) --}}
<div class="mt-6" x-data="{ open: false }">
    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-zinc-600 transition hover:text-zinc-400"
    >
        <i class="fa-solid fa-chevron-right text-[0.55rem] transition-transform duration-150" :class="open ? 'rotate-90' : ''" aria-hidden="true"></i>
        {{ __('backend.csv_import_toggle') }}
    </button>
    <div x-show="open" x-transition class="mt-3 rounded-xl border border-white/6 bg-zinc-900/60 p-4" style="display: none;">
        <p class="mb-3 text-xs text-zinc-500">{{ __('backend.headline_csv') }}</p>
        @if ($errors->has('csv'))
            <p class="mb-2 text-xs text-red-400">{{ $errors->first('csv') }}</p>
        @endif
        <form action="{{ route('add-deck-csv') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3">
            @csrf
            <label class="sr-only" for="csv-import">{{ __('backend.headline_csv') }}</label>
            <input type="file" id="csv-import" name="csv" accept=".csv,.txt" required
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
