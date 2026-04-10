{{--
    Shared faction form partial.
    $deck       → Deck model (edit) or null (add)
    $formAction → route string for form action
    $submitLabel → text for the submit button
--}}
@php
    $isEdit = isset($deck) && $deck !== null;
    $v = fn(string $field) => old($field, $isEdit ? $deck->{$field} : '');

    $steps = [
        1 => ['title' => 'Basic information',    'icon' => 'fa-circle-info'],
        2 => ['title' => 'Card information',     'icon' => 'fa-cards-blank'],
        3 => ['title' => 'Gameplay elements',    'icon' => 'fa-chess-knight'],
        4 => ['title' => 'Additional details',   'icon' => 'fa-list-check'],
        5 => ['title' => 'Final details',        'icon' => 'fa-flag-checkered'],
    ];

    $richFields = [
        'teaser', 'description',
        'cardsTeaser', 'actionTeaser', 'actionList',
        'actions', 'characters', 'bases',
        'clarifications', 'suggestionTeaser', 'synergy',
        'tips', 'mechanics', 'effects', 'playstyle',
    ];
@endphp

<form id="factionForm" action="{{ $formAction }}" method="POST">
    @csrf

    {{-- Step progress bar --}}
    <div class="mb-8" x-data="{ step: 1, total: 5 }">
        <div class="mb-6 flex items-center gap-2">
            @foreach($steps as $n => $s)
            <div class="flex flex-1 flex-col items-center gap-1.5">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full border text-xs font-bold transition"
                    :class="step >= {{ $n }}
                        ? 'border-indigo-500 bg-indigo-600 text-white'
                        : 'border-white/10 bg-zinc-900 text-zinc-600'"
                >{{ $n }}</div>
                <span class="hidden text-[0.6rem] font-semibold uppercase tracking-wide text-zinc-600 sm:block"
                    :class="step >= {{ $n }} ? 'text-indigo-400' : ''">{{ $s['title'] }}</span>
            </div>
            @if($n < 5)
            <div class="mb-4 h-px flex-1 bg-white/8" :class="step > {{ $n }} ? 'bg-indigo-500/40' : ''"></div>
            @endif
            @endforeach
        </div>

        {{-- Step panels --}}
        @foreach($steps as $n => $s)
        <div x-show="step === {{ $n }}" style="{{ $n === 1 ? '' : 'display:none' }}">
            <div class="mb-5 flex items-center gap-2 border-b border-white/8 pb-4">
                <i class="fa-solid {{ $s['icon'] }} text-sm text-indigo-400" aria-hidden="true"></i>
                <h2 class="text-sm font-bold uppercase tracking-wide text-zinc-300">Step {{ $n }}: {{ $s['title'] }}</h2>
            </div>

            <div class="flex flex-col gap-5">
                @if($n === 1)
                    {{-- Name (plain text) --}}
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-500">Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ $v('name') }}" required
                            class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <x-decks.rich-field id="teaser"       label="Teaser"       :value="$v('teaser')" />
                    <x-decks.rich-field id="description"  label="Description"  :value="$v('description')" />
                @elseif($n === 2)
                    <x-decks.rich-field id="cardsTeaser"  label="Cards Teaser"  :value="$v('cardsTeaser')" />
                    <x-decks.rich-field id="actionTeaser" label="Action Teaser" :value="$v('actionTeaser')" />
                    <x-decks.rich-field id="actionList"   label="Action List"   :value="$v('actionList')" />
                @elseif($n === 3)
                    <x-decks.rich-field id="actions"    label="Actions"    :value="$v('actions')" />
                    <x-decks.rich-field id="characters" label="Characters" :value="$v('characters')" />
                    <x-decks.rich-field id="bases"      label="Bases"      :value="$v('bases')" />
                @elseif($n === 4)
                    <x-decks.rich-field id="clarifications"  label="Clarifications"   :value="$v('clarifications')" />
                    <x-decks.rich-field id="suggestionTeaser" label="Suggestion Teaser" :value="$v('suggestionTeaser')" />
                    <x-decks.rich-field id="synergy"         label="Synergy"           :value="$v('synergy')" />
                @elseif($n === 5)
                    <x-decks.rich-field id="tips"      label="Tips"      :value="$v('tips')" />
                    <x-decks.rich-field id="mechanics" label="Mechanics" :value="$v('mechanics')" />
                    <div>
                        <label for="expansion" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-500">Expansion</label>
                        <input type="text" id="expansion" name="expansion" value="{{ $v('expansion') }}"
                            class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-zinc-100 outline-none transition focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <x-decks.rich-field id="effects"   label="Effects"   :value="$v('effects')" />
                    <x-decks.rich-field id="playstyle" label="Playstyle" :value="$v('playstyle')" />
                @endif
            </div>

            {{-- Navigation --}}
            <div class="mt-8 flex items-center justify-between">
                @if($n > 1)
                <button type="button" @click="step--"
                    class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2 text-sm font-semibold text-zinc-300 transition hover:border-white/20 hover:text-white">
                    <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i> Previous
                </button>
                @else
                <div></div>
                @endif

                @if($n < 5)
                <button type="button" @click="step++"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Next <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
                </button>
                @else
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.98]">
                    <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i>
                    {{ $submitLabel }}
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</form>

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
.ck-editor__editable { color: #000 !important; background: #fff !important; min-height: 80px; }
</style>
