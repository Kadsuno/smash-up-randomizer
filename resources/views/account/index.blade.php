<x-layouts.main>

    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-indigo-950/50 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-5%,rgb(99_102_241_/_0.10),transparent)]" aria-hidden="true"></div>
        <x-sur.container>
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">{{ __('frontend.account_eyebrow') }}</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    {{ __('frontend.account_heading', ['name' => $user->name]) }}
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-zinc-500">{{ __('frontend.account_sub') }}</p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    <x-sur.section>
        <x-sur.reveal>
            <div class="max-w-lg rounded-2xl border border-white/8 bg-zinc-900/60 p-6">
                @if(session('status') === 'verified')
                    <div class="mb-5 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-400">
                        <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                        {{ __('frontend.account_email_verified') }}
                    </div>
                @endif
                <dl class="divide-y divide-white/6">
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('frontend.auth_register_name') }}</dt>
                        <dd class="text-sm font-medium text-white">{{ $user->name }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('frontend.email') }}</dt>
                        <dd class="text-sm font-medium text-white">{{ $user->email }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('frontend.account_member_since') }}</dt>
                        <dd class="text-sm font-medium text-white">{{ $user->created_at->format('d M Y') }}</dd>
                    </div>
                </dl>
                <div class="mt-5 border-t border-white/6 pt-5">
                    <form method="POST" action="{{ route('frontend.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 rounded-xl border border-red-500/20 bg-red-900/20 px-4 py-2 text-sm font-semibold text-red-400 transition hover:border-red-500/40 hover:bg-red-900/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500/40">
                            <i class="fa-solid fa-right-from-bracket text-xs" aria-hidden="true"></i>
                            {{ __('frontend.nav_logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </x-sur.reveal>

        <x-sur.reveal>
            <div class="mt-10 rounded-2xl border border-dashed border-white/10 bg-zinc-900/30 p-8 text-center">
                <i class="fa-solid fa-layer-group mb-3 text-2xl text-zinc-700" aria-hidden="true"></i>
                <p class="text-sm font-semibold text-zinc-500">{{ __('frontend.account_features_soon') }}</p>
                <p class="mt-1 text-xs text-zinc-700">{{ __('frontend.account_features_soon_sub') }}</p>
            </div>
        </x-sur.reveal>
    </x-sur.section>

</x-layouts.main>
