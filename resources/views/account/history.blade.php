<x-layouts.main>
    <div class="relative min-h-screen bg-zinc-950 pt-14" style="padding-bottom: 6rem">
        <div class="sur-account-radial-bg" aria-hidden="true"></div>
        <x-sur.container class="relative z-10 max-w-3xl">
            <div class="mb-8">
                <a href="{{ route('account') }}" class="mb-5 inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-300">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.account_history_back') }}
                </a>
                <h1 class="text-xl font-bold text-white">{{ __('frontend.account_history_heading') }}</h1>
                <p class="mt-2 text-sm text-zinc-500">{{ __('frontend.account_history_sub') }}</p>
            </div>

            @if($history->isEmpty())
                <p class="rounded-2xl border border-white/10 bg-white/[0.04] px-6 py-12 text-center text-sm text-zinc-500">{{ __('frontend.account_history_empty') }}</p>
            @else
                <ul class="space-y-4">
                    @foreach($history as $row)
                        <li class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                            <div class="mb-3 flex flex-wrap items-center justify-between gap-2 text-xs text-zinc-500">
                                <span>{{ $row->created_at->timezone(config('app.timezone'))->format('Y-m-d H:i') }}</span>
                                <span class="rounded-full bg-zinc-800 px-2 py-0.5 text-zinc-400">{{ __('frontend.account_history_players', ['n' => $row->player_count]) }}</span>
                            </div>
                            <div class="space-y-2">
                                @foreach($row->results as $pi => $pair)
                                    <div class="flex flex-wrap items-center gap-2 text-sm">
                                        <span class="text-zinc-500">{{ __('frontend.account_history_player_label', ['num' => $pi + 1]) }}</span>
                                        @foreach($pair as $slot)
                                            <span class="rounded-lg border border-indigo-500/30 bg-indigo-500/10 px-2.5 py-1 text-indigo-200">{{ $slot['name'] }}</span>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-sur.container>
    </div>
</x-layouts.main>
