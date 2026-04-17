<x-layouts.main>
    <div class="relative min-h-screen bg-zinc-950 pt-14" style="padding-bottom: 6rem">
        <div class="sur-account-radial-bg" aria-hidden="true"></div>
        <x-sur.container class="relative z-10 max-w-4xl">
            <div class="mb-8">
                <a href="{{ route('account') }}" class="mb-5 inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-300">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.account_presets_back') }}
                </a>
                <h1 class="text-xl font-bold text-white">{{ __('frontend.account_presets_heading') }}</h1>
                <p class="mt-2 text-sm text-zinc-500">{{ __('frontend.account_presets_sub') }}</p>
            </div>

            @if(session('preset_status'))
                <div class="mb-6 flex items-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">
                    <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                    {{ session('preset_status') }}
                </div>
            @endif

            @if($presets->isNotEmpty())
                <div class="mb-10 space-y-3">
                    @foreach($presets as $preset)
                        <div class="flex flex-col gap-3 rounded-2xl border border-white/10 bg-white/[0.04] p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-white">{{ $preset->name }}</p>
                                <p class="mt-1 text-xs text-zinc-500">
                                    {{ __('frontend.account_preset_meta', ['players' => $preset->player_count]) }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('home', ['shuffle_preset' => $preset->id]) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-500">
                                    <i class="fa-solid fa-wand-magic-sparkles text-xs" aria-hidden="true"></i>
                                    {{ __('frontend.account_preset_apply') }}
                                </a>
                                <form method="POST" action="{{ route('account.presets.destroy', $preset) }}" onsubmit="return confirm({{ json_encode(__('frontend.account_preset_delete_confirm')) }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-sm text-zinc-400 transition hover:border-red-500/40 hover:text-red-400">
                                        {{ __('frontend.account_preset_delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @php
                $presetFactionListScroll = $factions->count() > 7;
            @endphp

            <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-7 shadow-xl">
                <h2 class="mb-8 text-lg font-semibold text-white">{{ __('frontend.account_preset_form_heading') }}</h2>
                <form method="POST" action="{{ route('account.presets.store') }}" class="flex flex-col gap-8">
                    @csrf

                    <div>
                        <label for="preset_name" class="mb-3 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_preset_name_label') }}</label>
                        <input type="text" name="name" id="preset_name" value="{{ old('name') }}" required maxlength="100" class="w-full rounded-xl border border-white/10 bg-zinc-900/60 px-4 py-2.5 text-sm text-white outline-none focus:border-indigo-500/60 @error('name') border-red-500/40 @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <p class="mb-3.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_preset_players_label') }}</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach ([2, 3, 4] as $n)
                                <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-sm text-zinc-300 has-[:checked]:border-indigo-500/60 has-[:checked]:bg-indigo-500/10">
                                    <input type="radio" name="player_count" value="{{ $n }}" class="text-indigo-500" @checked(old('player_count', '2') == (string) $n) required>
                                    {{ $n }} {{ __('frontend.shuffle_wizard_players_unit') }}
                                </label>
                            @endforeach
                        </div>
                        @error('player_count')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="mb-4 flex flex-col gap-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_preset_include_label') }}</p>
                            <p class="text-xs leading-relaxed text-zinc-500">{{ __('frontend.account_preset_optional_hint') }}</p>
                        </div>
                        <div @class([
                            'space-y-2 rounded-xl border border-white/10 bg-zinc-900/40 px-4 py-3 sur-scrollbar',
                            'max-h-52 overflow-y-auto' => $presetFactionListScroll,
                        ])>
                            @foreach($factions as $faction)
                                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-2 text-xs text-zinc-300 hover:bg-white/5">
                                    <input type="checkbox" name="include_factions[]" value="{{ $faction->name }}" class="rounded border-white/20" @checked(collect(old('include_factions', []))->contains($faction->name))>
                                    {{ $faction->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-white/[0.06] pt-8">
                        <p class="mb-4 text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_preset_exclude_label') }}</p>
                        <div @class([
                            'space-y-2 rounded-xl border border-white/10 bg-zinc-900/40 px-4 py-3 sur-scrollbar',
                            'max-h-52 overflow-y-auto' => $presetFactionListScroll,
                        ])>
                            @foreach($factions as $faction)
                                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-2 text-xs text-zinc-300 hover:bg-white/5">
                                    <input type="checkbox" name="exclude_factions[]" value="{{ $faction->name }}" class="rounded border-white/20" @checked(collect(old('exclude_factions', []))->contains($faction->name))>
                                    {{ $faction->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-white/[0.06] pt-8">
                        <button type="submit" class="sur-btn-primary inline-flex min-h-12 items-center gap-2 px-6 text-sm font-semibold">
                            <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i>
                            {{ __('frontend.account_preset_submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </x-sur.container>
    </div>
</x-layouts.main>
