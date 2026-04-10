<x-layouts.backend.backendMain>

    {{-- Page header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ __('backend.nav_faction_manager') }}</h1>
            <p class="mt-1 text-sm text-zinc-500">{{ $decks->count() }} factions total</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('add-deck') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.98]">
                <i class="fas fa-plus text-xs" aria-hidden="true"></i>
                {{ __('backend.add_decks') }}
            </a>
        </div>
    </div>

    {{-- CSV import --}}
    <div class="mb-6 rounded-xl border border-white/8 bg-zinc-900/60 p-4">
        <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('backend.headline_csv') }}</p>
        <form action="{{ route('add-deck-csv') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3">
            @csrf
            <label class="sr-only" for="csv-import">{{ __('backend.headline_csv') }}</label>
            <input type="file" id="csv-import" name="csv" accept=".csv" required
                class="block cursor-pointer rounded-xl border border-white/10 bg-zinc-800/60 px-3 py-2 text-sm text-zinc-200 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-500">
            <button class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2 text-sm font-semibold text-zinc-200 transition hover:border-white/20 hover:text-white" type="submit">
                <i class="fas fa-upload text-xs" aria-hidden="true"></i>
                {{ __('backend.upload') }}
            </button>
        </form>
    </div>

    {{-- Live-search + table --}}
    <div x-data="{
        search: '',
        get filtered() {
            if (!this.search.trim()) return true;
            return null;
        }
    }">
        <div class="mb-4">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-zinc-600" aria-hidden="true"></i>
                <input
                    x-model.debounce.200ms="search"
                    type="text"
                    placeholder="Search factions…"
                    class="w-full rounded-xl border border-white/10 bg-zinc-800/60 py-2.5 pl-10 pr-4 text-sm text-zinc-200 placeholder-zinc-600 outline-none transition focus:border-indigo-500/50 focus:ring-2 focus:ring-indigo-500/20 sm:max-w-sm"
                >
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-white/8 bg-zinc-900/60">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[26rem] text-left text-sm">
                    <thead class="border-b border-white/8">
                        <tr>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('backend.deck_name') }}</th>
                            <th class="px-4 py-3 text-end text-xs font-bold uppercase tracking-wide text-zinc-500">{{ __('backend.table_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach ($decks as $deck)
                        <tr
                            x-show="!search.trim() || '{{ strtolower($deck->name) }}'.includes(search.toLowerCase())"
                            class="transition hover:bg-white/[0.025]"
                        >
                            <td class="px-4 py-3 font-medium text-zinc-100">{{ $deck->name }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('edit-deck', $deck->name) }}"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-white/10 text-zinc-400 transition hover:border-indigo-500/40 hover:text-indigo-300"
                                        title="{{ __('backend.edit_deck') }}">
                                        <i class="fas fa-pencil text-xs" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('delete-decks', $deck->name) }}"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-500/20 text-red-400/70 transition hover:border-red-500/50 hover:bg-red-500/10 hover:text-red-300"
                                        title="{{ __('backend.delete_decks') }}"
                                        onclick="return confirm('{{ __('backend.confirm_delete') }}')">
                                        <i class="fas fa-trash-alt text-xs" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.backend.backendMain>
