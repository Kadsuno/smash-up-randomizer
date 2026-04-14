<x-layouts.main>
    {{-- Match resources/views/auth/frontend-login.blade.php structure & card styling --}}
    <section class="relative flex min-h-[calc(100vh-4rem)] flex-col items-center overflow-hidden px-4 py-12 sm:py-16">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_45%_at_50%_40%,rgb(99_102_241_/_0.08),transparent)]" aria-hidden="true"></div>

        <div class="relative w-full max-w-sm">
            <div class="mb-8">
                <a href="{{ route('account') }}" class="mb-5 inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-300">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.account_edit_back') }}
                </a>
                <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-zinc-600">{{ __('frontend.account_eyebrow') }}</p>
                <h1 class="text-xl font-bold text-white">{{ __('frontend.account_edit_page_heading') }}</h1>
                <p class="mt-2 text-sm text-zinc-500">{{ __('frontend.account_edit_page_sub') }}</p>
            </div>

            <div class="flex flex-col gap-8">
                {{-- Edit profile --}}
                <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm">
                    <h2 class="mb-6 text-center text-lg font-bold text-white">{{ __('frontend.account_edit_profile_heading') }}</h2>

                    @if(session('profile_status'))
                        <div class="mb-4 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-400">
                            <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                            {{ session('profile_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.profile.update') }}" novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_edit_profile_name') }}</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                autocomplete="name"
                                class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white placeholder-zinc-600 outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('name') border-red-500/40 @enderror"
                            >
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_edit_profile_email') }}</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                                class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white placeholder-zinc-600 outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('email') border-red-500/40 @enderror"
                            >
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 active:scale-[0.98]">
                            <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i>
                            {{ __('frontend.account_edit_profile_save') }}
                        </button>
                    </form>
                </div>

                {{-- Change password (hidden for OAuth-only accounts) --}}
                <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm">
                    <h2 class="mb-6 text-center text-lg font-bold text-white">{{ __('frontend.account_change_password_heading') }}</h2>

                    @if($user->password === null)
                        <p class="text-center text-sm leading-relaxed text-zinc-500">{{ __('frontend.account_password_oauth_hint') }}</p>
                    @else
                    @if(session('password_status'))
                        <div class="mb-4 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-400">
                            <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                            {{ session('password_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('account.password.update') }}" novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="current_password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_password_current') }}</label>
                            <input
                                id="current_password"
                                type="password"
                                name="current_password"
                                required
                                autocomplete="current-password"
                                class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 {{ $errors->passwordErrors->has('current_password') ? 'border-red-500/40' : '' }}"
                            >
                            @if($errors->passwordErrors->has('current_password'))
                                <p class="mt-1.5 text-xs text-red-400">{{ $errors->passwordErrors->first('current_password') }}</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_password_new') }}</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('password') border-red-500/40 @enderror"
                            >
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_password_confirm') }}</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20"
                            >
                        </div>

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 active:scale-[0.98]">
                            <i class="fa-solid fa-lock text-xs" aria-hidden="true"></i>
                            {{ __('frontend.account_password_save') }}
                        </button>
                    </form>
                    @endif
                </div>

                {{-- Two-factor authentication --}}
                <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm" id="mfa">
                    <h2 class="mb-6 text-center text-lg font-bold text-white">{{ __('frontend.two_factor_account_heading') }}</h2>

                    @if(session('mfa_recovery_codes'))
                        <div class="mb-4 rounded-lg border border-amber-500/30 bg-amber-900/20 px-4 py-3 text-sm text-amber-200">
                            <p class="mb-2 font-semibold">{{ __('frontend.two_factor_recovery_codes_title') }}</p>
                            <p class="mb-3 text-xs text-amber-200/80">{{ __('frontend.two_factor_recovery_codes_warning') }}</p>
                            <ul class="font-mono text-xs leading-relaxed">
                                @foreach(session('mfa_recovery_codes') as $rc)
                                    <li>{{ $rc }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('mfa_disabled'))
                        <div class="mb-4 flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-400">
                            <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                            {{ __('frontend.two_factor_disabled_message') }}
                        </div>
                    @endif

                    @if($user->hasTwoFactorEnabled())
                        <p class="mb-4 text-center text-sm text-emerald-400">
                            <i class="fa-solid fa-shield-halved mr-1" aria-hidden="true"></i>
                            {{ __('frontend.two_factor_status_on') }}
                        </p>

                        <form method="POST" action="{{ route('account.two-factor.recovery-codes') }}" class="mb-6 border-b border-white/10 pb-6">
                            @csrf
                            <p class="mb-3 text-sm text-zinc-500">{{ __('frontend.two_factor_regenerate_intro') }}</p>
                            <div class="mb-4">
                                <label for="mfa_regen_code" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.two_factor_code_label') }}</label>
                                <input
                                    id="mfa_regen_code"
                                    type="text"
                                    name="code"
                                    autocomplete="one-time-code"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 {{ $errors->twoFactorRecovery->has('code') ? 'border-red-500/40' : '' }}"
                                >
                                @if($errors->twoFactorRecovery->has('code'))
                                    <p class="mt-1.5 text-xs text-red-400">{{ $errors->twoFactorRecovery->first('code') }}</p>
                                @endif
                            </div>
                            <button type="submit" class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                {{ __('frontend.two_factor_regenerate_button') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('account.two-factor.disable') }}">
                            @csrf
                            @if($user->password !== null)
                                <p class="mb-3 text-sm text-zinc-500">{{ __('frontend.two_factor_disable_password_intro') }}</p>
                                <div class="mb-4">
                                    <label for="mfa_disable_password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.account_password_current') }}</label>
                                    <input
                                        id="mfa_disable_password"
                                        type="password"
                                        name="password"
                                        autocomplete="current-password"
                                        class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 {{ $errors->twoFactorDisable->has('password') ? 'border-red-500/40' : '' }}"
                                    >
                                    @if($errors->twoFactorDisable->has('password'))
                                        <p class="mt-1.5 text-xs text-red-400">{{ $errors->twoFactorDisable->first('password') }}</p>
                                    @endif
                                </div>
                            @else
                                <p class="mb-3 text-sm text-zinc-500">{{ __('frontend.two_factor_disable_oauth_intro') }}</p>
                                <div class="mb-4">
                                    <label for="mfa_disable_code" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.two_factor_code_or_recovery') }}</label>
                                    <input
                                        id="mfa_disable_code"
                                        type="text"
                                        name="code"
                                        autocomplete="one-time-code"
                                        class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 {{ $errors->twoFactorDisable->has('code') ? 'border-red-500/40' : '' }}"
                                    >
                                    @if($errors->twoFactorDisable->has('code'))
                                        <p class="mt-1.5 text-xs text-red-400">{{ $errors->twoFactorDisable->first('code') }}</p>
                                    @endif
                                </div>
                            @endif
                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-950/30 px-4 py-2.5 text-sm font-semibold text-red-300 transition hover:bg-red-950/50">
                                {{ __('frontend.two_factor_disable_button') }}
                            </button>
                        </form>
                    @else
                        <p class="mb-4 text-center text-sm text-zinc-500">{{ __('frontend.two_factor_status_off') }}</p>
                        <form method="POST" action="{{ route('account.two-factor.start') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                <i class="fa-solid fa-shield-halved text-xs" aria-hidden="true"></i>
                                {{ __('frontend.two_factor_enable_button') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.main>
