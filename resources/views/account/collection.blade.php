<x-layouts.main>
    <div class="relative min-h-screen bg-zinc-950 pt-14" style="padding-bottom: 6rem">
        <div class="sur-account-radial-bg" aria-hidden="true"></div>
        <x-sur.container class="relative z-10 max-w-3xl">
            <div class="mb-8">
                <a href="{{ route('account') }}" class="mb-5 inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-300">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.account_collection_back') }}
                </a>
                <h1 class="text-xl font-bold text-white">{{ __('frontend.account_collection_heading') }}</h1>
                <p class="mt-2 text-sm text-zinc-500">{{ __('frontend.account_collection_sub') }}</p>
            </div>

            @if(session('collection_status'))
                <div class="mb-6 flex items-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">
                    <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                    {{ session('collection_status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('account.collection.update') }}" class="rounded-2xl border border-white/10 bg-white/[0.04] p-7 shadow-xl">
                @csrf
                @method('PUT')

                <p class="mb-6 text-sm leading-relaxed text-zinc-400">{{ __('frontend.account_collection_hint') }}</p>

                <div class="mb-8 max-h-[28rem] space-y-2 overflow-y-auto rounded-xl border border-white/10 bg-zinc-900/40 p-4 sur-scrollbar">
                    @forelse($expansions as $expansion)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2 transition hover:bg-white/5">
                            <input
                                type="checkbox"
                                name="expansions[]"
                                value="{{ $expansion }}"
                                class="h-4 w-4 rounded border-white/20 bg-zinc-800 text-indigo-500 focus:ring-indigo-500/50"
                                @checked(in_array($expansion, $selectedExpansions, true))
                            >
                            <span class="text-sm text-zinc-200">{{ $expansion }}</span>
                        </label>
                    @empty
                        <p class="text-sm text-zinc-500">{{ __('frontend.account_collection_no_expansions') }}</p>
                    @endforelse
                </div>

                <button type="submit" class="sur-btn-primary inline-flex min-h-12 items-center gap-2 px-6 text-sm font-semibold">
                    <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i>
                    {{ __('frontend.account_collection_save') }}
                </button>
            </form>
        </x-sur.container>
    </div>
</x-layouts.main>
