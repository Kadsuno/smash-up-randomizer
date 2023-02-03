<x-layouts.main>
    <section class="w-100 px-4 py-5">
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
                        <x-label for="email" :value="__('Email address')" />
                        <x-input id="email" class="form-control form-control-lg" type="email" name="email" :value="old('email')"
                        required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="form-outline mb-4">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="form-control form-control-lg" type="password" name="password" required
                        autocomplete="current-password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <label for="remember_me" class="form-check-label">
                            <input id="remember_me" type="checkbox"
                                class="form-check-input"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                        <a class="text-decoration-none"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center">
                        

                        <x-button class="btn btn-primary btn-lg btn-block">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

    </section>
</x-layouts.main>