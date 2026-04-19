<x-layouts.main>
    <section class="relative flex min-h-[calc(100vh-4rem)] flex-col items-center overflow-hidden px-4 py-12 sm:py-16">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_45%_at_50%_40%,rgb(99_102_241_/_0.08),transparent)]" aria-hidden="true"></div>

        <div class="relative w-full max-w-sm">
            <div class="mb-8">
                <a href="{{ route('account.edit') }}" class="mb-5 inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-300">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.two_factor_setup_back') }}
                </a>
                <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-zinc-600">{{ __('frontend.account_eyebrow') }}</p>
                <h1 class="text-xl font-bold text-white">{{ __('frontend.two_factor_setup_heading') }}</h1>
                <p class="mt-2 text-sm text-zinc-500">{{ __('frontend.two_factor_setup_sub') }}</p>
            </div>

            @if($errors->twoFactor->any())
                <div class="mb-4 flex items-start gap-2 rounded-lg border border-red-500/20 bg-red-900/20 px-4 py-3 text-sm text-red-400">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0" aria-hidden="true"></i>
                    <ul class="list-none">@foreach($errors->twoFactor->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm">
                <div class="mb-6 flex justify-center rounded-xl border border-white/10 bg-white p-4">
                    {!! $qrSvg !!}
                </div>
                <p class="mb-2 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('frontend.two_factor_manual_secret') }}</p>
                <p class="mb-6 break-all text-center font-mono text-sm text-zinc-300">{{ $secret }}</p>

                <form method="POST" action="{{ route('account.two-factor.confirm') }}" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="code" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.two_factor_code_label') }}</label>
                        <input
                            id="code"
                            type="text"
                            name="code"
                            value="{{ old('code') }}"
                            required
                            autocomplete="one-time-code"
                            inputmode="numeric"
                            class="sur-input @error('code', 'twoFactor') border-red-500/40 @enderror"
                        >
                        @error('code', 'twoFactor')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="sur-btn-primary mb-3 w-full gap-2">
                        <i class="fa-solid fa-check text-xs" aria-hidden="true"></i>
                        {{ __('frontend.two_factor_setup_confirm') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('account.two-factor.cancel') }}">
                    @csrf
                    <button type="submit" class="sur-btn-ghost w-full">
                        {{ __('frontend.two_factor_setup_cancel') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.main>
