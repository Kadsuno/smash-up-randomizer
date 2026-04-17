<x-layouts.backend.backendMain>

@php
    $v = fn(string $field) => old($field, $deck->{$field} ?? '');

    $richFields = [
        'teaser', 'description',
        'cardsTeaser', 'actionTeaser', 'actionList',
        'actions', 'characters', 'bases',
        'clarifications', 'suggestionTeaser', 'synergy',
        'tips', 'mechanics', 'effects', 'playstyle',
    ];

    $contentFields = [
        'teaser'          => 'Teaser',
        'description'     => 'Description',
        'cardsTeaser'     => 'Cards',
        'actionTeaser'    => 'Action Teaser',
        'actionList'      => 'Action List',
        'actions'         => 'Actions',
        'characters'      => 'Characters',
        'bases'           => 'Bases',
        'clarifications'  => 'Clarifications',
        'synergy'         => 'Synergy',
        'tips'            => 'Tips',
        'mechanics'       => 'Mechanics',
        'playstyle'       => 'Playstyle',
    ];

    $filledCount = collect($contentFields)->keys()->filter(fn($f) => !empty($deck->{$f}))->count();
    $totalFields = count($contentFields);
    $pct         = $totalFields > 0 ? round($filledCount / $totalFields * 100) : 0;
@endphp

{{-- Sticky save bar --}}
<div class="sticky top-14 z-30 -mx-6 -mt-8 mb-8 border-b border-white/6 bg-zinc-950/90 px-6 py-3 backdrop-blur-sm">
    <div class="mx-auto flex max-w-5xl items-center justify-between gap-4">
        <div class="min-w-0">
            <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">
                <a href="{{ route('decks-manager') }}" class="transition hover:text-zinc-400">Faction Manager</a>
                <span class="mx-1 text-zinc-700">/</span>
                <span class="text-zinc-500">Edit</span>
            </p>
            <h1 class="truncate text-base font-bold text-white">{{ $deck->name }}</h1>
        </div>
        <button type="submit" form="factionForm"
            class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.98]">
            <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i>
            Save changes
        </button>
    </div>
</div>

{{-- Content completeness bar --}}
<div class="mb-6 rounded-xl border border-white/6 bg-zinc-900/60 px-5 py-4">
    <div class="mb-2 flex items-center justify-between text-xs">
        <span class="font-semibold uppercase tracking-wide text-zinc-500">Content completeness</span>
        <span class="font-bold {{ $pct === 100 ? 'text-emerald-400' : ($pct > 50 ? 'text-sky-400' : 'text-amber-400') }}">
            {{ $filledCount }} / {{ $totalFields }} fields &middot; {{ $pct }}%
        </span>
    </div>
    <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-800">
        <div class="h-1.5 rounded-full transition-all duration-500
            {{ $pct === 100 ? 'bg-emerald-500' : ($pct > 50 ? 'bg-sky-500' : 'bg-amber-500') }}"
            style="width: {{ $pct }}%"></div>
    </div>
    <div class="mt-3 flex flex-wrap gap-1.5">
        @foreach($contentFields as $field => $label)
        @php $filled = !empty($deck->{$field}); @endphp
        <span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-[0.6rem] font-semibold
            {{ $filled ? 'bg-emerald-500/10 text-emerald-400' : 'bg-zinc-800 text-zinc-600' }}">
            <i class="fa-solid {{ $filled ? 'fa-check' : 'fa-minus' }} text-[0.5rem]" aria-hidden="true"></i>
            {{ $label }}
        </span>
        @endforeach
    </div>
</div>

{{-- Validation errors --}}
@if($errors->any())
<div class="mb-6 flex items-start gap-3 rounded-xl border border-red-500/20 bg-red-900/10 px-4 py-3 text-sm text-red-400">
    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0" aria-hidden="true"></i>
    <ul class="list-none space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Form --}}
<form id="factionForm" action="{{ route('update-deck', $deck->name) }}" method="POST">
    @csrf

    {{-- ── Section 1: Basic information ───────────────────────────── --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
        <div class="flex items-center gap-2 border-b border-white/6 px-5 py-3.5">
            <i class="fa-solid fa-circle-info text-sm text-indigo-400" aria-hidden="true"></i>
            <h2 class="text-xs font-bold uppercase tracking-wide text-zinc-400">Basic information</h2>
        </div>
        <div class="flex flex-col gap-5 p-5">

            {{-- Name + Expansion row --}}
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-500">
                        Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ $v('name') }}" required
                        class="w-full rounded-xl border border-white/8 bg-zinc-800/60 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 @error('name') border-red-500/40 @enderror">
                </div>
                <div>
                    <label for="expansion" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-500">Expansion</label>
                    <input type="text" id="expansion" name="expansion" value="{{ $v('expansion') }}"
                        class="w-full rounded-xl border border-white/8 bg-zinc-800/60 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20">
                </div>
            </div>

            <x-decks.rich-field id="teaser"      label="Teaser"      :value="$v('teaser')" />
            <x-decks.rich-field id="description" label="Description" :value="$v('description')" />
        </div>
    </div>

    {{-- ── Section 2: Card information ─────────────────────────────── --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
        <div class="flex items-center gap-2 border-b border-white/6 px-5 py-3.5">
            <i class="fa-solid fa-cards-blank text-sm text-indigo-400" aria-hidden="true"></i>
            <h2 class="text-xs font-bold uppercase tracking-wide text-zinc-400">Card information</h2>
        </div>
        <div class="flex flex-col gap-5 p-5">
            <x-decks.rich-field id="cardsTeaser"  label="Cards Teaser"  :value="$v('cardsTeaser')" />
            <x-decks.rich-field id="actionTeaser" label="Action Teaser" :value="$v('actionTeaser')" />
            <x-decks.rich-field id="actionList"   label="Action List"   :value="$v('actionList')" />
        </div>
    </div>

    {{-- ── Section 3: Gameplay elements ────────────────────────────── --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
        <div class="flex items-center gap-2 border-b border-white/6 px-5 py-3.5">
            <i class="fa-solid fa-chess-knight text-sm text-indigo-400" aria-hidden="true"></i>
            <h2 class="text-xs font-bold uppercase tracking-wide text-zinc-400">Gameplay elements</h2>
        </div>
        <div class="flex flex-col gap-5 p-5">
            <x-decks.rich-field id="actions"    label="Actions"    :value="$v('actions')" />
            <x-decks.rich-field id="characters" label="Characters" :value="$v('characters')" />
            <x-decks.rich-field id="bases"      label="Bases"      :value="$v('bases')" />
        </div>
    </div>

    {{-- ── Section 4: Additional details ───────────────────────────── --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
        <div class="flex items-center gap-2 border-b border-white/6 px-5 py-3.5">
            <i class="fa-solid fa-list-check text-sm text-indigo-400" aria-hidden="true"></i>
            <h2 class="text-xs font-bold uppercase tracking-wide text-zinc-400">Additional details</h2>
        </div>
        <div class="flex flex-col gap-5 p-5">
            <x-decks.rich-field id="clarifications"   label="Clarifications"    :value="$v('clarifications')" />
            <x-decks.rich-field id="suggestionTeaser" label="Suggestion Teaser" :value="$v('suggestionTeaser')" />
            <x-decks.rich-field id="synergy"          label="Synergy"           :value="$v('synergy')" />
        </div>
    </div>

    {{-- ── Section 5: Strategy & mechanics ─────────────────────────── --}}
    <div class="mb-8 overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
        <div class="flex items-center gap-2 border-b border-white/6 px-5 py-3.5">
            <i class="fa-solid fa-flag-checkered text-sm text-indigo-400" aria-hidden="true"></i>
            <h2 class="text-xs font-bold uppercase tracking-wide text-zinc-400">Strategy & mechanics</h2>
        </div>
        <div class="flex flex-col gap-5 p-5">
            <x-decks.rich-field id="tips"      label="Tips"      :value="$v('tips')" />
            <x-decks.rich-field id="mechanics" label="Mechanics" :value="$v('mechanics')" />
            <x-decks.rich-field id="effects"   label="Effects"   :value="$v('effects')" />
            <x-decks.rich-field id="playstyle" label="Playstyle" :value="$v('playstyle')" />
        </div>
    </div>

    {{-- Bottom save button --}}
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('decks-manager') }}" class="text-sm text-zinc-600 transition hover:text-zinc-400">Cancel</a>
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.98]">
            <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i>
            Save changes
        </button>
    </div>

</form>

{{-- ── Danger zone ─────────────────────────────────────────────── --}}
<div class="mt-10 rounded-xl border border-red-500/15 bg-red-950/10 p-5">
    <h3 class="mb-1 text-xs font-bold uppercase tracking-wide text-red-400">Danger zone</h3>
    <p class="mb-4 text-xs text-zinc-600">Permanently delete this faction. This action cannot be undone.</p>
    <form action="{{ route('delete-decks', ['name' => $deck->name]) }}" method="POST" class="inline"
        onsubmit="return confirm(@json(__('backend.confirm_delete')))">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm font-semibold text-red-400 transition hover:bg-red-500/20 hover:text-red-300">
            <i class="fa-solid fa-trash-alt text-xs" aria-hidden="true"></i>
            Delete {{ $deck->name }}
        </button>
    </form>
</div>

{{-- CKEditor 5 --}}
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const richFields = @json($richFields);

    richFields.forEach(function (field) {
        const el = document.getElementById(field);
        if (!el) return;

        ClassicEditor.create(el, {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        }).then(function (editor) {
            const hidden = document.querySelector('input[name="' + field + '"]');
            if (hidden && hidden.value) editor.setData(hidden.value);
            editor.model.document.on('change:data', function () {
                if (hidden) hidden.value = editor.getData();
            });
        }).catch(console.error);
    });
});
</script>

<style>
/* CKEditor dark theme */
.ck.ck-editor__main > .ck-editor__editable,
.ck.ck-editor__editable {
    background: #18181b !important;
    color: #e4e4e7 !important;
    border-color: rgba(255,255,255,0.08) !important;
    min-height: 100px;
}
.ck.ck-toolbar {
    background: #27272a !important;
    border-color: rgba(255,255,255,0.08) !important;
}
.ck.ck-toolbar .ck-toolbar__separator { background: rgba(255,255,255,0.1) !important; }
.ck.ck-button, .ck.ck-button.ck-on { color: #a1a1aa !important; background: transparent !important; }
.ck.ck-button:hover, .ck.ck-button.ck-on:hover { background: rgba(255,255,255,0.06) !important; color: #fff !important; }
.ck.ck-button.ck-on { color: #818cf8 !important; }
.ck.ck-editor__editable.ck-focused { border-color: rgba(99,102,241,0.4) !important; box-shadow: 0 0 0 2px rgba(99,102,241,0.15) !important; }
.ck-dropdown__panel, .ck.ck-list { background: #27272a !important; border-color: rgba(255,255,255,0.08) !important; }
.ck.ck-list__item .ck-button { color: #d4d4d8 !important; }
.ck.ck-list__item .ck-button:hover { background: rgba(255,255,255,0.06) !important; }
.ck.ck-list__item .ck-button.ck-on { background: rgba(99,102,241,0.2) !important; color: #818cf8 !important; }
</style>

</x-layouts.backend.backendMain>
