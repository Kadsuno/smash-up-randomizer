<x-layouts.main>
    <section class="w-100 px-5 py-5 mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="{{ asset('images/login.svg') }}" class="img-fluid" alt="Phone image">
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-outline mb-4">
                        <label class="mb-2" for="email">{{ __('frontend.email') }}</label>
                        <x-input id="email" class="form-control form-control-lg" type="email" placeholder="name@example.com" name="email" :value="old('email')"
                        required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="form-outline mb-4">
                        <label for="password" class="mb-2">{{ __('frontend.password') }}</label>
                        <x-input id="password" class="form-control form-control-lg" type="password" name="password" required
                        autocomplete="current-password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="d-flex mb-4">
                        <label for="remember_me" class="form-check-label">
                            <input id="remember_me" type="checkbox"
                                class="form-check-input"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('frontend.remember_me') }}</span>
                        </label>
{{--                         @if (Route::has('password.request'))
                        <a class="text-decoration-none"
                            href="{{ route('password.request') }}">
                            {{ __('frontend.password_forget') }}
                        </a>
                        @endif
 --}}                    </div>

                    <div class="d-flex justify-content-center">
                        

                        <x-button class="btn btn-primary btn-lg btn-block">
                            {{ __('frontend.login') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.main>