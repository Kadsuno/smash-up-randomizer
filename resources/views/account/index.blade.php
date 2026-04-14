<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-indigo-950/60 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_55%_at_50%_-10%,rgb(99_102_241_/_0.12),transparent)]" aria-hidden="true"></div>
        {{-- Subtle grid texture --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.03] [background-image:linear-gradient(to_right,#fff_1px,transparent_1px),linear-gradient(to_bottom,#fff_1px,transparent_1px)] [background-size:40px_40px]" aria-hidden="true"></div>

        <x-sur.container>
            <x-sur.reveal>
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">{{ __('frontend.account_eyebrow') }}</p>
                        <div class="flex items-center gap-4">
                            {{-- Avatar --}}
                            <span class="relative flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-gradient-to-br from-indigo-600 to-violet-700 text-xl font-bold text-white shadow-lg shadow-indigo-900/30">
                                {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                <span class="absolute -bottom-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full border-2 border-zinc-950 bg-emerald-500"></span>
                            </span>
                            <div>
                                <h1 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                                    {{ __('frontend.account_heading', ['name' => $user->name]) }}
                                </h1>
                                <p class="mt-0.5 text-sm text-zinc-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Logout button in hero --}}
                    <form method="POST" action="{{ route('frontend.logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/[0.04] px-4 py-2 text-sm text-zinc-400 transition hover:border-red-500/30 hover:bg-red-900/10 hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500/40">
                            <i class="fa-solid fa-right-from-bracket text-xs" aria-hidden="true"></i>
                            {{ __('frontend.nav_logout') }}
                        </button>
                    </form>
                </div>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    <x-sur.section>
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Left column: profile card --}}
            <div class="lg:col-span-1">
                <x-sur.reveal>
                    <div class="rounded-2xl border border-white/8 bg-zinc-900/60 overflow-hidden">

                        {{-- Card header --}}
                        <div class="border-b border-white/6 px-5 py-4">
                            <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ __('frontend.account_profile_section') }}</h2>
                        </div>

                        @if(session('status') === 'verified')
                            <div class="mx-5 mt-4 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-3 py-2.5 text-xs font-medium text-emerald-400">
                                <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                                {{ __('frontend.account_email_verified') }}
                            </div>
                        @endif

                        <dl class="divide-y divide-white/6 px-5">
                            <div class="flex items-center gap-3 py-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400">
                                    <i class="fa-solid fa-user text-xs" aria-hidden="true"></i>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">{{ __('frontend.auth_register_name') }}</dt>
                                    <dd class="truncate text-sm font-medium text-white">{{ $user->name }}</dd>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-violet-500/10 text-violet-400">
                                    <i class="fa-solid fa-envelope text-xs" aria-hidden="true"></i>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">{{ __('frontend.email') }}</dt>
                                    <dd class="truncate text-sm font-medium text-white">{{ $user->email }}</dd>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-700/40 text-zinc-400">
                                    <i class="fa-solid fa-calendar-days text-xs" aria-hidden="true"></i>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">{{ __('frontend.account_member_since') }}</dt>
                                    <dd class="text-sm font-medium text-white">{{ $user->created_at->format('d M Y') }}</dd>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 py-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-400">
                                    <i class="fa-solid fa-shield-halved text-xs" aria-hidden="true"></i>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">{{ __('frontend.account_role') }}</dt>
                                    <dd class="text-sm font-medium text-white capitalize">{{ $user->role }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </x-sur.reveal>
            </div>

            {{-- Right column: upcoming features --}}
            <div class="space-y-5 lg:col-span-2">

                {{-- Stats row --}}
                <x-sur.reveal>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach([
                            ['icon' => 'fa-layer-group', 'color' => 'indigo', 'label' => __('frontend.account_stat_factions'), 'value' => '—'],
                            ['icon' => 'fa-shuffle',     'color' => 'violet', 'label' => __('frontend.account_stat_shuffles'), 'value' => '—'],
                            ['icon' => 'fa-clock-rotate-left', 'color' => 'sky', 'label' => __('frontend.account_stat_history'), 'value' => '—'],
                        ] as $stat)
                            <div class="rounded-2xl border border-white/8 bg-zinc-900/60 p-4 text-center">
                                <span class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-xl bg-{{ $stat['color'] }}-500/10 text-{{ $stat['color'] }}-400 text-sm">
                                    <i class="fa-solid {{ $stat['icon'] }}" aria-hidden="true"></i>
                                </span>
                                <p class="text-xl font-bold text-white">{{ $stat['value'] }}</p>
                                <p class="mt-0.5 text-[0.65rem] font-semibold uppercase tracking-wide text-zinc-600">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </x-sur.reveal>

                {{-- Coming soon feature cards --}}
                <x-sur.reveal>
                    <div class="rounded-2xl border border-white/8 bg-zinc-900/60 overflow-hidden">
                        <div class="border-b border-white/6 px-5 py-4 flex items-center justify-between">
                            <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ __('frontend.account_features_soon') }}</h2>
                            <span class="rounded-full border border-indigo-500/30 bg-indigo-500/10 px-2.5 py-0.5 text-[0.65rem] font-semibold uppercase tracking-wide text-indigo-400">
                                {{ __('frontend.account_coming_soon_badge') }}
                            </span>
                        </div>
                        <div class="divide-y divide-white/6">
                            @foreach([
                                ['icon' => 'fa-layer-group', 'color' => 'indigo',  'title' => __('frontend.account_feat_collection_title'), 'body' => __('frontend.account_feat_collection_body')],
                                ['icon' => 'fa-bookmark',    'color' => 'violet',   'title' => __('frontend.account_feat_presets_title'),    'body' => __('frontend.account_feat_presets_body')],
                                ['icon' => 'fa-clock-rotate-left', 'color' => 'sky', 'title' => __('frontend.account_feat_history_title'),  'body' => __('frontend.account_feat_history_body')],
                            ] as $feat)
                                <div class="flex items-start gap-4 px-5 py-4">
                                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-{{ $feat['color'] }}-500/10 text-{{ $feat['color'] }}-400">
                                        <i class="fa-solid {{ $feat['icon'] }} text-sm" aria-hidden="true"></i>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-white">{{ $feat['title'] }}</p>
                                        <p class="mt-0.5 text-xs leading-relaxed text-zinc-500">{{ $feat['body'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-sur.reveal>

                {{-- Quick actions --}}
                <x-sur.reveal>
                    <div class="rounded-2xl border border-white/8 bg-zinc-900/60 overflow-hidden">
                        <div class="border-b border-white/6 px-5 py-4">
                            <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ __('frontend.account_quick_actions') }}</h2>
                        </div>
                        <div class="flex flex-wrap gap-3 p-5">
                            <a href="{{ route('home') }}#wizard" class="sur-btn-primary flex items-center gap-2 rounded-xl px-4 py-2 text-sm">
                                <i class="fa-solid fa-shuffle text-xs" aria-hidden="true"></i>
                                {{ __('frontend.nav_shuffle') }}
                            </a>
                            <a href="{{ route('factionList') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/[0.04] px-4 py-2 text-sm text-zinc-300 transition hover:bg-white/[0.08] hover:text-white">
                                <i class="fa-solid fa-layer-group text-xs" aria-hidden="true"></i>
                                {{ __('frontend.nav_factions') }}
                            </a>
                        </div>
                    </div>
                </x-sur.reveal>

            </div>
        </div>
    </x-sur.section>

</x-layouts.main>
