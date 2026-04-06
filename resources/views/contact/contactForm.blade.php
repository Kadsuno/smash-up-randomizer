<x-layouts.main>
    <div id="hero-header" class="animate__animated animate__fadeIn">
        <div class="relative w-full overflow-hidden">
            <div class="bg-options min-h-[50vh] sm:min-h-[60vh]" id="hero-js" style="background-image: url('{{ asset('images/contact_2.png') }}'); background-attachment: scroll; background-position: center; background-size: cover;">
                <div class="mx-auto max-w-7xl px-4 sm:px-6">
                    <div class="max-w-xl py-10 sm:py-16">
                        <div class="rounded-2xl border border-white/10 bg-black/70 px-6 py-8 shadow-2xl backdrop-blur-md animate__animated animate__slideInLeft sm:px-8">
                            <h1 class="mb-4 text-3xl font-extrabold text-white sm:text-4xl">
                                Contact Us
                            </h1>
                            <p class="text-sm leading-relaxed text-zinc-200 sm:text-base">
                                Do you have a question, want to find out more about Smash Up Randomizer or just want to say hello? Then you've come to the right place! We are always open to inquiries, feedback or exciting stories about our shared hobby. Simply fill out the contact form or send us an e-mail. We look forward to hearing from you. We'll get back to you faster than you can shuffle cards!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
        <h2 class="mb-8 text-center text-2xl font-bold text-white animate__animated animate__fadeInDown">
            Contact Form
        </h2>
    </div>
    <div class="mx-auto mb-16 max-w-7xl px-4 sm:px-6">
        <div class="mx-auto max-w-3xl">
            @if (Session::has('success'))
            <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-center text-sm text-emerald-200 animate__animated animate__fadeIn">
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::has('error'))
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-center text-sm text-red-200 animate__animated animate__fadeIn">
                {{ Session::get('error') }}
            </div>
            @endif
            <form method="POST" action="{{ route('contact.us.store') }}" id="contactUSForm" class="needs-validation sur-card border-white/10 p-6 animate__animated animate__fadeInUp sm:p-8" novalidate>
                {{ csrf_field() }}

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-zinc-300">Name: <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="name" class="sur-input" placeholder="Your Name" value="{{ old('name') }}" required>
                        @if ($errors->has('name'))
                        <span class="mt-1 block text-sm text-red-400">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-zinc-300">Email: <span class="text-red-400">*</span></label>
                        <input type="email" name="email" id="email" class="sur-input" placeholder="Your Email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                        <span class="mt-1 block text-sm text-red-400">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-zinc-300">Phone: <span class="text-red-400">*</span></label>
                        <input type="tel" name="phone" id="phone" class="sur-input" placeholder="Your Phone" value="{{ old('phone') }}" required>
                        @if ($errors->has('phone'))
                        <span class="mt-1 block text-sm text-red-400">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="subject" class="mb-2 block text-sm font-medium text-zinc-300">Subject: <span class="text-red-400">*</span></label>
                        <input type="text" name="subject" id="subject" class="sur-input" placeholder="Message Subject" value="{{ old('subject') }}" required>
                        @if ($errors->has('subject'))
                        <span class="mt-1 block text-sm text-red-400">{{ $errors->first('subject') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <label for="message" class="mb-2 block text-sm font-medium text-zinc-300">Message: <span class="text-red-400">*</span></label>
                    <textarea name="message" id="message" rows="5" placeholder="What is on your mind?" class="sur-input min-h-[8rem]" required>{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                    <span class="mt-1 block text-sm text-red-400">{{ $errors->first('message') }}</span>
                    @endif
                </div>

                <input type="text" name="context" id="context" class="hidden" tabindex="-1" autocomplete="off">
                <input type="hidden" name="start_time" value="{{ time() }}">

                <div class="mt-8 text-center">
                    <button type="submit" class="sur-btn-primary min-h-12 animate__animated animate__pulse animate__infinite">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.main>

<style>
    .bg-options {
        background-repeat: no-repeat;
        background-position: center;
    }
    .animate__animated {
        animation-duration: 1s;
    }
</style>
