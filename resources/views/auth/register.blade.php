<x-layouts.main>
    <section class="w-100 px-4 py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="{{ asset('images/login.svg') }}" class="img-fluid" alt="Phone image">
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-outline mb-4">
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="form-control form-control-lg" type="text" name="name"
                            :value="old('name')" required autofocus />
                    </div>

                    <!-- Email Address -->
                    <div class="form-outline mb-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="form-control form-control-lg" type="email" name="email"
                            :value="old('email')" required />
                    </div>

                    <!-- Password -->
                    <div class="form-outline mb-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="form-control form-control-lg" type="password" name="password"
                            required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-outline mb-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="form-control form-control-lg" type="password"
                            name="password_confirmation" required />
                    </div>

                    <div class="text-center">
                        <a class="text-decoration-none pr-5" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        <x-button class="btn btn-primary btn-lg btn-block">
                            {{ __('Register') }}
                        </x-button>
                    </div>
            </div>
            </form>
        </div>
        </div>
    </section>
</x-layouts.main>