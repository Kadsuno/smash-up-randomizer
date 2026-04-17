<x-layouts.main>
    <section class="relative flex min-h-[calc(100vh-4rem)] items-center justify-center overflow-hidden px-4 py-16">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_45%_at_50%_40%,rgb(99_102_241_/_0.08),transparent)]" aria-hidden="true"></div>
        <div class="relative w-full max-w-sm">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 text-white/80 transition hover:text-white">
                    <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Smash Up Randomizer" class="h-8 w-8">
                    <span class="text-sm font-semibold tracking-wide">Smash Up Randomizer</span>
                </a>
                <p class="mt-3 text-xs font-semibold uppercase tracking-widest text-zinc-600">{{ __('frontend.auth_register_eyebrow') }}</p>
            </div>
            @if($errors->any())
                <div class="mb-4 flex items-start gap-2 rounded-lg border border-red-500/20 bg-red-900/20 px-4 py-3 text-sm text-red-400">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0" aria-hidden="true"></i>
                    <ul class="list-none">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            <div class="rounded-2xl border border-white/8 bg-zinc-900/80 p-7 shadow-2xl backdrop-blur-sm">
                <h1 class="mb-6 text-center text-lg font-bold text-white">{{ __('frontend.auth_register_heading') }}</h1>
                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.auth_register_name') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('name') border-red-500/40 @enderror">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('email') border-red-500/40 @enderror">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20 @error('password') border-red-500/40 @enderror">
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-400">{{ __('frontend.auth_register_confirm_password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-xl border border-white/10 bg-zinc-800/60 px-4 py-2.5 text-sm text-white outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 active:scale-[0.98]">
                        <i class="fa-solid fa-user-plus text-xs" aria-hidden="true"></i>
                        {{ __('frontend.auth_register_submit') }}
                    </button>
                </form>
                <x-auth.social-buttons />
            </div>
            <p class="mt-5 text-center text-xs text-zinc-600">
                {{ __('frontend.auth_register_have_account') }}
                <a href="{{ route('login') }}" class="text-indigo-500 transition hover:text-indigo-400">{{ __('frontend.auth_login_link') }}</a>
            </p>
            <p class="mt-3 text-center text-xs text-zinc-700">
                <a href="{{ route('home') }}" class="transition hover:text-zinc-400">← {{ __('frontend.auth_back_to_site') }}</a>
            </p>
        </div>
    </section>
</x-layouts.main>
