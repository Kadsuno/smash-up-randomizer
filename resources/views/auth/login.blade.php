<x-layouts.main>
    <section class="mx-auto mt-8 max-w-6xl px-4 py-8 sm:mt-12 sm:px-6">
        <div class="flex flex-col gap-10 lg:flex-row lg:items-start lg:justify-center">
            <div class="flex justify-center lg:w-2/5">
                <img src="{{ asset('images/login.svg') }}" class="max-h-72 w-full max-w-md object-contain" alt="" width="400" height="300">
            </div>
            <div class="mx-auto w-full max-w-md flex-1">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <div class="sur-card border-cyan-500/20 p-6 sm:p-8">
                    <h1 class="mb-6 text-center text-xl font-bold text-white sm:text-2xl">{{ __('frontend.login') }}</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium text-zinc-300" for="email">{{ __('frontend.email') }}</label>
                            <x-input id="email" type="email" placeholder="name@example.com" name="email" :value="old('email')"
                                required autofocus />
                        </div>

                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium text-zinc-300" for="password">{{ __('frontend.password') }}</label>
                            <x-input id="password" type="password" name="password" required
                                autocomplete="current-password" />
                        </div>

                        <div class="mb-6 flex items-center gap-2">
                            <input id="remember_me" type="checkbox"
                                class="h-4 w-4 rounded border-white/20 bg-zinc-800 text-cyan-500 focus:ring-cyan-500/50"
                                name="remember">
                            <label for="remember_me" class="text-sm text-zinc-400">{{ __('frontend.remember_me') }}</label>
                        </div>

                        <div class="flex justify-center">
                            <x-button class="w-full min-h-12 sm:w-auto">
                                {{ __('frontend.login') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.main>
