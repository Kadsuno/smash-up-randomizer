<x-layouts.main>

    {{-- Page background: gradient centered in viewport (not above fold only) + explicit z stacking --}}
    <div class="relative min-h-screen bg-zinc-950 pt-14" style="padding-bottom: 10rem">
        <div class="sur-account-radial-bg" aria-hidden="true"></div>
        <div class="sur-account-grid-bg" aria-hidden="true"></div>

        <x-sur.container class="relative z-10">

            {{-- Profile card --}}
            <x-sur.reveal>
                <div class="mb-6 rounded-2xl border border-white/10 bg-white/[0.04] p-8 shadow-xl shadow-black/30 backdrop-blur-sm">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-5">
                            <div class="relative shrink-0">
                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 text-2xl font-bold text-white select-none ring-4 ring-indigo-500/20">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </span>
                                <span class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full border-2 border-zinc-950 bg-emerald-500"></span>
                            </div>
                            <div>
                                <h1 class="text-lg font-semibold text-white">{{ $user->name }}</h1>
                                <p class="mt-0.5 text-sm text-zinc-400">{{ $user->email }}</p>
                                <p class="mt-1.5 text-xs text-zinc-600">{{ __('frontend.account_member_since') }}: {{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    <div class="flex shrink-0 items-center gap-3">
                        <a href="{{ route('account.edit') }}" class="sur-btn-secondary inline-flex items-center gap-2">
                            <i class="fa-solid fa-pen text-xs" aria-hidden="true"></i>
                            {{ __('frontend.account_edit_link') }}
                        </a>
                        <form method="POST" action="{{ route('frontend.logout') }}">
                            @csrf
                            <button type="submit" class="sur-btn-secondary inline-flex items-center gap-2 hover:border-red-500/40 hover:bg-red-500/10 hover:text-red-400 focus-visible:ring-red-500/40">
                                <i class="fa-solid fa-right-from-bracket text-xs" aria-hidden="true"></i>
                                {{ __('frontend.nav_logout') }}
                            </button>
                        </form>
                    </div>
                    </div>

                    @if(session('status') === 'verified')
                        <div class="mt-6 flex items-center gap-2.5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">
                            <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                            {{ __('frontend.account_email_verified') }}
                        </div>
                    @endif
                </div>
            </x-sur.reveal>

            {{-- Stats --}}
            <x-sur.reveal>
                <div class="mb-6 grid grid-cols-3 gap-4">
                    @php
                        $stats = [
                            ['icon' => 'fa-layer-group',       'bg' => 'bg-indigo-500/15', 'ring' => 'ring-indigo-500/20', 'text' => 'text-indigo-300', 'label' => __('frontend.account_stat_expansions'), 'value' => (string) $statOwnedExpansions, 'href' => route('account.collection')],
                            ['icon' => 'fa-bookmark',          'bg' => 'bg-violet-500/15', 'ring' => 'ring-violet-500/20', 'text' => 'text-violet-300', 'label' => __('frontend.account_stat_presets'), 'value' => (string) $statPresetCount, 'href' => route('account.presets')],
                            ['icon' => 'fa-clock-rotate-left', 'bg' => 'bg-sky-500/15',    'ring' => 'ring-sky-500/20',    'text' => 'text-sky-300',    'label' => __('frontend.account_stat_shuffles'), 'value' => (string) $statShuffleCount, 'href' => route('account.history')],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <a href="{{ $stat['href'] }}" class="group flex flex-col items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.04] py-14 text-center shadow-lg shadow-black/20 backdrop-blur-sm transition hover:border-indigo-500/35 hover:bg-white/[0.07]">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $stat['bg'] }} {{ $stat['text'] }} ring-1 {{ $stat['ring'] }} transition group-hover:scale-105">
                                <i class="fa-solid {{ $stat['icon'] }} text-lg" aria-hidden="true"></i>
                            </span>
                            <div>
                                <p class="text-2xl font-bold leading-none text-white">{{ $stat['value'] }}</p>
                                <p class="mt-2 text-xs font-medium text-zinc-500">{{ $stat['label'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </x-sur.reveal>

            {{-- Logged-in features --}}
            <x-sur.reveal>
                <div class="mb-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-zinc-400">{{ __('frontend.account_features_heading') }}</h2>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        @php
                            $features = [
                                [
                                    'href'    => route('account.collection'),
                                    'icon'    => 'fa-layer-group',
                                    'bg'      => 'bg-indigo-500/15',
                                    'ring'    => 'ring-indigo-500/20',
                                    'text'    => 'text-indigo-300',
                                    'glow'    => 'from-indigo-900/30',
                                    'title'   => __('frontend.account_feat_collection_title'),
                                    'body'    => __('frontend.account_feat_collection_body'),
                                    'cta'     => __('frontend.account_feat_collection_cta'),
                                ],
                                [
                                    'href'    => route('account.presets'),
                                    'icon'    => 'fa-bookmark',
                                    'bg'      => 'bg-violet-500/15',
                                    'ring'    => 'ring-violet-500/20',
                                    'text'    => 'text-violet-300',
                                    'glow'    => 'from-violet-900/30',
                                    'title'   => __('frontend.account_feat_presets_title'),
                                    'body'    => __('frontend.account_feat_presets_body'),
                                    'cta'     => __('frontend.account_feat_presets_cta'),
                                ],
                                [
                                    'href'    => route('account.history'),
                                    'icon'    => 'fa-clock-rotate-left',
                                    'bg'      => 'bg-sky-500/15',
                                    'ring'    => 'ring-sky-500/20',
                                    'text'    => 'text-sky-300',
                                    'glow'    => 'from-sky-900/30',
                                    'title'   => __('frontend.account_feat_history_title'),
                                    'body'    => __('frontend.account_feat_history_body'),
                                    'cta'     => __('frontend.account_feat_history_cta'),
                                ],
                            ];
                        @endphp
                        @foreach($features as $feat)
                            <a href="{{ $feat['href'] }}" class="group relative block overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-lg shadow-black/20 backdrop-blur-sm transition hover:border-indigo-500/35 hover:bg-white/[0.06]">
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b {{ $feat['glow'] }} to-transparent opacity-60" aria-hidden="true"></div>
                                <div class="relative">
                                    <span class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl {{ $feat['bg'] }} {{ $feat['text'] }} ring-1 {{ $feat['ring'] }} transition group-hover:scale-105">
                                        <i class="fa-solid {{ $feat['icon'] }} text-lg" aria-hidden="true"></i>
                                    </span>
                                    <h3 class="mb-2 text-sm font-semibold text-white">{{ $feat['title'] }}</h3>
                                    <p class="text-xs leading-relaxed text-zinc-500">{{ $feat['body'] }}</p>
                                    <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-400 group-hover:text-indigo-300">
                                        {{ $feat['cta'] }}
                                        <i class="fa-solid fa-arrow-right text-[0.65rem] transition group-hover:translate-x-0.5" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </x-sur.reveal>

            {{-- Quick actions --}}
            <x-sur.reveal>
                <div class="inline-block rounded-2xl border border-white/10 bg-white/[0.04] shadow-lg shadow-black/20 backdrop-blur-sm" style="padding: 2.5rem 2rem">
                    <h2 class="mb-5 text-sm font-semibold text-zinc-400">{{ __('frontend.account_quick_actions') }}</h2>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('home') }}#wizard" class="sur-btn-primary inline-flex items-center gap-2">
                            <i class="fa-solid fa-shuffle text-xs" aria-hidden="true"></i>
                            {{ __('frontend.nav_shuffle') }}
                        </a>
                        <a href="{{ route('factionList') }}" class="sur-btn-secondary inline-flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-xs" aria-hidden="true"></i>
                            {{ __('frontend.nav_factions') }}
                        </a>
                    </div>
                </div>
            </x-sur.reveal>


        </x-sur.container>
    </div>

</x-layouts.main>
