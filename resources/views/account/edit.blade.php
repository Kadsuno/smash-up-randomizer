<x-layouts.main>

    <div class="relative min-h-screen bg-zinc-950 pt-14" style="padding-bottom: 10rem">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_50%_at_50%_-5%,rgb(99_102_241_/_0.18),transparent)]" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.025] [background-image:linear-gradient(to_right,#fff_1px,transparent_1px),linear-gradient(to_bottom,#fff_1px,transparent_1px)] [background-size:40px_40px]" aria-hidden="true"></div>

        <x-sur.container class="relative">

            {{-- Back link + page heading --}}
            <x-sur.reveal>
                <div class="mb-8">
                    <a href="{{ route('account') }}" class="mb-6 inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-300">
                        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                        {{ __('frontend.account_edit_back') }}
                    </a>
                    <h1 class="text-2xl font-semibold text-white">{{ __('frontend.account_edit_page_heading') }}</h1>
                    <p class="mt-1 text-sm text-zinc-500">{{ __('frontend.account_edit_page_sub') }}</p>
                </div>
            </x-sur.reveal>

            <div class="mx-auto max-w-2xl space-y-6">

                {{-- Edit profile --}}
                <x-sur.reveal>
                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] shadow-lg shadow-black/20 backdrop-blur-sm">
                        <div class="border-b border-white/8 px-8 py-6">
                            <h2 class="text-base font-semibold text-white">{{ __('frontend.account_edit_profile_heading') }}</h2>
                        </div>

                        @if(session('profile_status'))
                            <div class="mx-8 mt-6 flex items-center gap-2.5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">
                                <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                                {{ session('profile_status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('account.profile.update') }}" class="px-8 py-6" novalidate>
                            @csrf
                            @method('PATCH')

                            <div class="space-y-5">
                                <div>
                                    <label for="name" class="mb-1.5 block text-xs font-semibold text-zinc-400">
                                        {{ __('frontend.account_edit_profile_name') }}
                                    </label>
                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        autocomplete="name"
                                        class="w-full rounded-xl border px-4 py-3 text-sm text-white placeholder-zinc-600 outline-none transition focus:ring-2
                                            {{ $errors->has('name') ? 'border-red-500/60 bg-red-500/5 focus:ring-red-500/30' : 'border-white/10 bg-white/[0.04] focus:border-indigo-500/60 focus:ring-indigo-500/20' }}"
                                    >
                                    @error('name')
                                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="mb-1.5 block text-xs font-semibold text-zinc-400">
                                        {{ __('frontend.account_edit_profile_email') }}
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                        autocomplete="email"
                                        class="w-full rounded-xl border px-4 py-3 text-sm text-white placeholder-zinc-600 outline-none transition focus:ring-2
                                            {{ $errors->has('email') ? 'border-red-500/60 bg-red-500/5 focus:ring-red-500/30' : 'border-white/10 bg-white/[0.04] focus:border-indigo-500/60 focus:ring-indigo-500/20' }}"
                                    >
                                    @error('email')
                                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="sur-btn-primary inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-medium">
                                    <i class="fa-solid fa-floppy-disk text-xs" aria-hidden="true"></i>
                                    {{ __('frontend.account_edit_profile_save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </x-sur.reveal>

                {{-- Change password --}}
                <x-sur.reveal>
                    <div class="rounded-2xl border border-white/10 bg-white/[0.04] shadow-lg shadow-black/20 backdrop-blur-sm">
                        <div class="border-b border-white/8 px-8 py-6">
                            <h2 class="text-base font-semibold text-white">{{ __('frontend.account_change_password_heading') }}</h2>
                        </div>

                        @if(session('password_status'))
                            <div class="mx-8 mt-6 flex items-center gap-2.5 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">
                                <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                                {{ session('password_status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('account.password.update') }}" class="px-8 py-6" novalidate>
                            @csrf
                            @method('PATCH')

                            <div class="space-y-5">
                                <div>
                                    <label for="current_password" class="mb-1.5 block text-xs font-semibold text-zinc-400">
                                        {{ __('frontend.account_password_current') }}
                                    </label>
                                    <input
                                        id="current_password"
                                        type="password"
                                        name="current_password"
                                        required
                                        autocomplete="current-password"
                                        class="w-full rounded-xl border px-4 py-3 text-sm text-white placeholder-zinc-600 outline-none transition focus:ring-2
                                            {{ $errors->passwordErrors->has('current_password') ? 'border-red-500/60 bg-red-500/5 focus:ring-red-500/30' : 'border-white/10 bg-white/[0.04] focus:border-indigo-500/60 focus:ring-indigo-500/20' }}"
                                    >
                                    @if($errors->passwordErrors->has('current_password'))
                                        <p class="mt-1.5 text-xs text-red-400">{{ $errors->passwordErrors->first('current_password') }}</p>
                                    @endif
                                </div>

                                <div>
                                    <label for="password" class="mb-1.5 block text-xs font-semibold text-zinc-400">
                                        {{ __('frontend.account_password_new') }}
                                    </label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                        class="w-full rounded-xl border px-4 py-3 text-sm text-white placeholder-zinc-600 outline-none transition focus:ring-2
                                            {{ $errors->passwordErrors->has('password') ? 'border-red-500/60 bg-red-500/5 focus:ring-red-500/30' : 'border-white/10 bg-white/[0.04] focus:border-indigo-500/60 focus:ring-indigo-500/20' }}"
                                    >
                                    @if($errors->passwordErrors->has('password'))
                                        <p class="mt-1.5 text-xs text-red-400">{{ $errors->passwordErrors->first('password') }}</p>
                                    @endif
                                </div>

                                <div>
                                    <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold text-zinc-400">
                                        {{ __('frontend.account_password_confirm') }}
                                    </label>
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                        class="w-full rounded-xl border border-white/10 bg-white/[0.04] px-4 py-3 text-sm text-white placeholder-zinc-600 outline-none transition focus:border-indigo-500/60 focus:ring-2 focus:ring-indigo-500/20"
                                    >
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="sur-btn-primary inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-medium">
                                    <i class="fa-solid fa-lock text-xs" aria-hidden="true"></i>
                                    {{ __('frontend.account_password_save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </x-sur.reveal>

            </div>
        </x-sur.container>
    </div>

</x-layouts.main>
