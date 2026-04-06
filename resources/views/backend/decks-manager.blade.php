<x-layouts.backend.backendMain>
    <div class="animate__animated animate__fadeIn">
        <h1 class="mb-8 text-center text-3xl font-bold text-white animate__animated animate__slideInDown">{{ __('backend.nav_faction_manager') }}</h1>

        <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <a href="{{ route('add-deck') }}" class="sur-btn-primary inline-flex min-h-12 w-fit animate__animated animate__pulse items-center gap-2">
                <i class="fas fa-plus" aria-hidden="true"></i> {{ __('backend.add_decks') }}
            </a>
            <form action="{{ route('add-deck-csv') }}" method="POST" enctype="multipart/form-data" class="flex w-full max-w-xl flex-col gap-3 sm:flex-row sm:items-center">
                @csrf
                <label class="sr-only" for="csv-import">{{ __('backend.headline_csv') }}</label>
                <input type="file" id="csv-import" name="csv" accept=".csv" required
                    class="block w-full cursor-pointer rounded-xl border border-white/10 bg-zinc-900/80 px-3 py-2 text-sm text-zinc-200 file:mr-3 file:rounded-lg file:border-0 file:bg-cyan-600 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-950 hover:file:bg-cyan-500">
                <button class="sur-btn-secondary min-h-11 shrink-0" type="submit">{{ __('backend.upload') }}</button>
            </form>
        </div>

        <div class="sur-card overflow-hidden border-white/10 p-0 animate__animated animate__fadeInUp">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[28rem] text-left text-sm text-zinc-300">
                    <thead class="border-b border-white/10 bg-zinc-900/80 text-xs uppercase tracking-wide text-zinc-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">{{ __('backend.deck_name') }}</th>
                            <th class="px-4 py-3 text-end font-semibold">{{ __('backend.table_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach ($decks as $deck)
                            <tr class="transition hover:bg-white/[0.03] animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <td class="px-4 py-3 font-medium text-zinc-100">{{ $deck->name }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('edit-deck', $deck->name) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 text-zinc-200 transition hover:border-cyan-500/40 hover:text-cyan-300" title="{{ __('backend.edit_deck') }}">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('delete-decks', $deck->name) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/30 text-red-300 transition hover:bg-red-500/10" title="{{ __('backend.delete_decks') }}" onclick="return confirm('{{ __('backend.confirm_delete') }}')">
                                            <i class="fas fa-trash-alt" aria-hidden="true"></i>
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

    <style>
        .animate__animated {
            animation-duration: 0.5s;
        }
    </style>
</x-layouts.backend.backendMain>
