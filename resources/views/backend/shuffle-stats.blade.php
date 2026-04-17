<x-layouts.backend.backendMain>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">{{ __('backend.shuffle_stats_title') }}</h1>
    <p class="mt-1 text-sm text-zinc-500">{{ __('backend.shuffle_stats_subtitle') }}</p>
</div>

<div class="mb-6 rounded-xl border border-white/8 bg-zinc-900/60 p-6">
    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-600">{{ __('backend.stat_shuffle_runs_total') }}</p>
    <p class="mt-1 text-3xl font-extrabold text-white">{{ $total }}</p>
</div>

@if($byPlayers->isNotEmpty())
<div class="mb-8 rounded-xl border border-white/8 bg-zinc-900/60 p-6">
    <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-zinc-400">{{ __('backend.shuffle_by_players') }}</h2>
    <div class="flex flex-wrap gap-3">
        @foreach($byPlayers as $row)
        <span class="rounded-lg border border-white/6 bg-zinc-800/60 px-3 py-1.5 text-sm text-zinc-300">
            {{ __('backend.shuffle_bucket', ['players' => $row->player_count, 'count' => $row->cnt]) }}
        </span>
        @endforeach
    </div>
</div>
@endif

<div class="rounded-xl border border-white/6 bg-zinc-900/60">
    <div class="border-b border-white/6 px-4 py-3 text-xs font-bold uppercase tracking-wide text-zinc-600">
        {{ __('backend.shuffle_recent') }}
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[36rem] text-left text-sm">
            <thead>
                <tr class="border-b border-white/6 text-xs text-zinc-600">
                    <th class="px-4 py-2">{{ __('backend.shuffle_col_when') }}</th>
                    <th class="px-4 py-2">{{ __('backend.shuffle_col_user') }}</th>
                    <th class="px-4 py-2">{{ __('backend.shuffle_col_players') }}</th>
                    <th class="px-4 py-2">{{ __('backend.shuffle_col_preview') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.04]">
                @forelse($recent as $row)
                <tr class="hover:bg-white/[0.02]">
                    <td class="px-4 py-2.5 text-zinc-500 whitespace-nowrap">{{ $row->created_at?->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2.5 text-zinc-300">
                        @if($row->user)
                            {{ $row->user->email }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-2.5 text-zinc-400">{{ $row->player_count }}</td>
                    <td class="px-4 py-2.5 text-xs text-zinc-500 truncate max-w-[20rem]">
                        @php $preview = collect($row->results ?? [])->flatten(1)->pluck('name')->take(6)->implode(', '); @endphp
                        {{ $preview ?: '—' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-10 text-center text-zinc-500">{{ __('backend.shuffle_empty') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</x-layouts.backend.backendMain>
