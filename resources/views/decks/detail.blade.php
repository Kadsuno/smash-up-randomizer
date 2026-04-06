<x-layouts.main>
    <div class="scroll-container">
        <div class="fixed left-0 top-0 z-[1000] m-3 pt-20">
            <a href="{{ route('factionList') }}" class="sur-btn-secondary inline-flex min-h-11 items-center gap-2 shadow-lg">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>Back to List
            </a>
        </div>

        <section class="scroll-section flex min-h-screen items-center" id="intro">
            <div class="mx-auto w-full max-w-5xl px-4 sm:px-6">
                <h1 class="text-center text-4xl font-black tracking-tight text-shadow text-white drop-shadow-lg sm:text-6xl md:text-7xl">
                    {{ $deck->name }}
                </h1>
                <div class="mt-6 text-center text-lg leading-relaxed text-zinc-100 sm:text-xl">{!! $deck->teaser !!}</div>
            </div>
        </section>

        <section class="scroll-section flex min-h-screen items-center px-4 py-16 sm:px-6" id="description">
            <div class="mx-auto w-full max-w-5xl">
                <div class="sur-card border-white/10">
                    <h2 class="mb-6 text-center text-3xl font-bold text-cyan-300 sm:text-4xl">
                        <i class="fas fa-info-circle me-3" aria-hidden="true"></i>Description
                    </h2>
                    <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->description !!}</div>
                </div>
            </div>
        </section>

        <section class="scroll-section flex min-h-screen items-center px-4 py-16 sm:px-6" id="cards">
            <div class="mx-auto w-full max-w-5xl">
                <div class="sur-card border-white/10">
                    <h2 class="mb-6 text-center text-3xl font-bold text-cyan-300 sm:text-4xl">
                        <i class="fas fa-layer-group me-3" aria-hidden="true"></i>Cards
                    </h2>
                    <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->cardsTeaser !!}</div>
                    <h3 class="mb-3 mt-8 text-center text-xl font-semibold text-white">
                        <i class="fas fa-bolt me-2 text-amber-400" aria-hidden="true"></i>Actions
                    </h3>
                    <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->actionTeaser !!}</div>
                    <div class="deck-html mt-4 text-zinc-300 leading-relaxed">
                        {!! $deck->actionList !!}
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section flex min-h-screen items-center px-4 py-16 sm:px-6" id="gameplay">
            <div class="mx-auto w-full max-w-5xl">
                <div class="sur-card border-white/10">
                    <h2 class="mb-8 text-center text-3xl font-bold text-cyan-300 sm:text-4xl">
                        <i class="fas fa-gamepad me-3" aria-hidden="true"></i>Gameplay
                    </h2>
                    <div class="grid gap-8 md:grid-cols-2">
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-bolt me-2 text-amber-400" aria-hidden="true"></i>Actions
                            </h3>
                            <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->actions !!}</div>
                        </div>
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-user me-2 text-cyan-400" aria-hidden="true"></i>Characters
                            </h3>
                            <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->characters !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section flex min-h-screen items-center px-4 py-16 sm:px-6" id="strategy">
            <div class="mx-auto w-full max-w-5xl">
                <div class="sur-card border-white/10">
                    <h2 class="mb-6 text-center text-3xl font-bold text-cyan-300 sm:text-4xl">
                        <i class="fas fa-chess me-3" aria-hidden="true"></i>Strategy
                    </h2>
                    <div class="deck-html mb-8 text-center text-zinc-300 leading-relaxed">{!! $deck->suggestionTeaser !!}</div>
                    <div class="mt-4 grid gap-8 md:grid-cols-2">
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-link me-2 text-cyan-400" aria-hidden="true"></i>Synergy
                            </h3>
                            <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->synergy !!}</div>
                        </div>
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-lightbulb me-2 text-amber-400" aria-hidden="true"></i>Tips
                            </h3>
                            <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->tips !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section flex min-h-screen items-center px-4 py-16 sm:px-6" id="additional-info">
            <div class="mx-auto w-full max-w-5xl">
                <div class="sur-card border-white/10">
                    <h2 class="mb-8 text-center text-3xl font-bold text-cyan-300 sm:text-4xl">
                        <i class="fas fa-info-circle me-3" aria-hidden="true"></i>Additional Info
                    </h2>
                    <div class="grid gap-8 md:grid-cols-3">
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-cogs me-2" aria-hidden="true"></i>Mechanics
                            </h3>
                            <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->mechanics !!}</div>
                        </div>
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-box-open me-2" aria-hidden="true"></i>Expansion
                            </h3>
                            <div class="deck-html text-center text-zinc-300 leading-relaxed">{!! $deck->expansion !!}</div>
                        </div>
                        <div>
                            <h3 class="mb-3 text-center text-lg font-semibold text-white">
                                <i class="fas fa-dice me-2" aria-hidden="true"></i>Playstyle
                            </h3>
                            <div class="deck-html text-zinc-300 leading-relaxed">{!! $deck->playstyle !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.main>

<style>
    body {
        overflow-x: hidden;
    }

    .scroll-container {
        height: 100vh;
        overflow-y: scroll;
        scroll-snap-type: y mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .scroll-container::-webkit-scrollbar {
        width: 0;
        height: 0;
    }

    .scroll-section {
        scroll-snap-align: start;
        position: relative;
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .scroll-section.active {
        opacity: 1;
        transform: translateY(0);
    }

    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    #intro {
        background: url('{{ $deck->image }}') no-repeat center center;
        background-size: cover;
    }

    #intro::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.65));
    }

    #intro .mx-auto {
        position: relative;
        z-index: 1;
    }

    .deck-html p {
        margin-bottom: 0.75rem;
    }
    .deck-html ul {
        list-style: disc;
        padding-left: 1.25rem;
        margin-bottom: 0.75rem;
    }
    .deck-html a {
        color: #22d3ee;
        text-decoration: underline;
        text-underline-offset: 2px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sections = document.querySelectorAll('.scroll-section');
        const navItems = document.querySelectorAll('nav a');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    const id = entry.target.getAttribute('id');
                    history.pushState(null, '', `#${id}`);
                    navItems.forEach((item) => {
                        item.classList.remove('active');
                        if (item.getAttribute('href') === `#${id}`) {
                            item.classList.add('active');
                        }
                    });
                } else {
                    entry.target.classList.remove('active');
                }
            });
        }, { root: null, rootMargin: '0px', threshold: 0.1 });

        sections.forEach((section) => observer.observe(section));
    });
</script>
