<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-linear-to-br from-violet-950/50 via-zinc-950 to-zinc-950 py-20 md:py-24">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_-10%,rgb(139_92_246_/_0.10),transparent)]" aria-hidden="true"></div>

        <x-sur.container :narrow="true">
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-violet-400">Contact</p>
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                    Got something to say?<br class="hidden sm:block"> We're listening.
                </h1>
                <p class="mt-5 max-w-xl text-base leading-relaxed text-zinc-400 sm:text-lg">
                    Bug report, missing faction, or just want to say hi — drop us a message and we'll get back to you.
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Main content --}}
    <x-sur.section>
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">

            {{-- Form column --}}
            <div class="lg:col-span-7">
                <x-sur.reveal>

                    @if (Session::has('success'))
                        <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-200">
                            <i class="fa-solid fa-circle-check mt-0.5 shrink-0 text-emerald-400" aria-hidden="true"></i>
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm text-red-200">
                            <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0 text-red-400" aria-hidden="true"></i>
                            <span>{{ Session::get('error') }}</span>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('contact.us.store') }}"
                        id="contactUSForm"
                        class="needs-validation sur-card border-white/10 p-6 sm:p-8"
                        novalidate
                    >
                        {{ csrf_field() }}

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-zinc-300">
                                    Name <span class="text-red-400" aria-hidden="true">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="sur-input"
                                    placeholder="Your name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                >
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-medium text-zinc-300">
                                    Email <span class="text-red-400" aria-hidden="true">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="sur-input"
                                    placeholder="you@example.com"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="subject" class="mb-1.5 block text-sm font-medium text-zinc-300">
                                Subject <span class="text-red-400" aria-hidden="true">*</span>
                            </label>
                            <select name="subject" id="subject" class="sur-input" required>
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>What's this about?</option>
                                <option value="Bug report" {{ old('subject') === 'Bug report' ? 'selected' : '' }}>🐛 Bug report</option>
                                <option value="Missing faction" {{ old('subject') === 'Missing faction' ? 'selected' : '' }}>🃏 Missing faction</option>
                                <option value="Feature request" {{ old('subject') === 'Feature request' ? 'selected' : '' }}>💡 Feature request</option>
                                <option value="General feedback" {{ old('subject') === 'General feedback' ? 'selected' : '' }}>💬 General feedback</option>
                                <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>📩 Other</option>
                            </select>
                            @error('subject')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-5">
                            <label for="message" class="mb-1.5 block text-sm font-medium text-zinc-300">
                                Message <span class="text-red-400" aria-hidden="true">*</span>
                            </label>
                            <textarea
                                name="message"
                                id="message"
                                rows="6"
                                placeholder="Tell us what's on your mind..."
                                class="sur-input min-h-[9rem] resize-y"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Honeypot + timing spam protection --}}
                        <input type="text" name="context" id="context" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
                        <input type="hidden" name="start_time" value="{{ time() }}">

                        <div class="mt-7">
                            <button type="submit" class="sur-btn-primary min-h-12 w-full sm:w-auto sm:px-10">
                                <i class="fa-solid fa-paper-plane me-2" aria-hidden="true"></i>
                                Send message
                            </button>
                        </div>
                    </form>
                </x-sur.reveal>
            </div>

            {{-- Info sidebar --}}
            <div class="lg:col-span-5">
                <x-sur.reveal :delay="60">
                    <div class="flex flex-col gap-6">

                        {{-- Direct email --}}
                        <div class="sur-card border-white/8 p-5">
                            <p class="mb-1 text-xs font-bold uppercase tracking-widest text-violet-400">Or reach us directly</p>
                            <a
                                href="mailto:info@smash-up-randomizer.com"
                                class="mt-2 inline-flex items-center gap-2 text-sm font-medium text-indigo-300 transition hover:text-indigo-200"
                            >
                                <i class="fa-regular fa-envelope text-base" aria-hidden="true"></i>
                                info@smash-up-randomizer.com
                            </a>
                        </div>

                        {{-- What we can help with --}}
                        <div class="sur-card border-white/8 p-5">
                            <p class="mb-4 text-xs font-bold uppercase tracking-widest text-violet-400">What we can help with</p>
                            <ul class="space-y-3 text-sm text-zinc-400">
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 text-base">🐛</span>
                                    <span><strong class="font-medium text-zinc-200">Bug reports</strong> — something broken or behaving oddly?</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 text-base">🃏</span>
                                    <span><strong class="font-medium text-zinc-200">Missing factions</strong> — a new expansion dropped and it's not in the list?</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 text-base">💡</span>
                                    <span><strong class="font-medium text-zinc-200">Feature requests</strong> — an idea that would make game nights better?</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 text-base">💬</span>
                                    <span><strong class="font-medium text-zinc-200">General feedback</strong> — good or bad, we want to hear it.</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Response time --}}
                        <div class="flex items-start gap-3 rounded-xl border border-white/6 bg-zinc-900/40 px-5 py-4 text-sm text-zinc-500">
                            <i class="fa-regular fa-clock mt-0.5 shrink-0 text-zinc-600" aria-hidden="true"></i>
                            <span>We usually respond within <strong class="font-medium text-zinc-400">1–2 business days</strong>. This is a one-person side project, so we appreciate your patience.</span>
                        </div>

                    </div>
                </x-sur.reveal>
            </div>

        </div>
    </x-sur.section>

</x-layouts.main>
