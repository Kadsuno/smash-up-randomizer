<x-layouts.main>
    <div class="scroll-container">
        <div class="position-fixed top-0 start-0 m-3 pt-5 z-index-1000">
            <a href="{{ route('factionList') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
        
        <section class="scroll-section vh-100 d-flex align-items-center" id="intro">
            <div class="container">
                <h1 class="display-1 text-center text-shadow">
                    {{ $deck->name }}
                </h1>
                <p class="lead text-center mt-4">{!! $deck->teaser !!}</p>
            </div>
        </section>

        <section class="scroll-section vh-100 d-flex align-items-center" id="description">
            <div class="container">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h2 class="display-4 text-center text-primary mb-4">
                            <i class="fas fa-info-circle me-3"></i>Description
                        </h2>
                        <p>{!! $deck->description !!}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section vh-100 d-flex align-items-center" id="cards">
            <div class="container">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h2 class="display-4 text-center text-primary mb-4">
                            <i class="fas fa-layer-group me-3"></i>Cards
                        </h2>
                        <p>{!! $deck->cardsTeaser !!}</p>
                        <h3 class="h4 mt-4 mb-3 text-center">
                            <i class="fas fa-bolt me-2"></i>Actions
                        </h3>
                        <p>{!! $deck->actionTeaser !!}</p>
                        <div class="mt-4">
                            {!! $deck->actionList !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section vh-100 d-flex align-items-center" id="gameplay">
            <div class="container">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h2 class="display-4 text-center text-primary mb-4">
                            <i class="fas fa-gamepad me-3"></i>Gameplay
                        </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-bolt me-2"></i>Actions
                                </h3>
                                <p>{!! $deck->actions !!}</p>
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-user me-2"></i>Characters
                                </h3>
                                <p>{!! $deck->characters !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section vh-100 d-flex align-items-center" id="strategy">
            <div class="container">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h2 class="display-4 text-center text-primary mb-4">
                            <i class="fas fa-chess me-3"></i>Strategy
                        </h2>
                        <p class="text-center">{!! $deck->suggestionTeaser !!}</p>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-link me-2"></i>Synergy
                                </h3>
                                <p>{!! $deck->synergy !!}</p>
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-lightbulb me-2"></i>Tips
                                </h3>
                                <p>{!! $deck->tips !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="scroll-section vh-100 d-flex align-items-center" id="additional-info">
            <div class="container">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h2 class="display-4 text-center text-primary mb-4">
                            <i class="fas fa-info-circle me-3"></i>Additional Info
                        </h2>
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-cogs me-2"></i>Mechanics
                                </h3>
                                <p>{!! $deck->mechanics !!}</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-box-open me-2"></i>Expansion
                                </h3>
                                <p class="text-center">{!! $deck->expansion !!}</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="h5 mb-3 text-center">
                                    <i class="fas fa-dice me-2"></i>Playstyle
                                </h3>
                                <p>{!! $deck->playstyle !!}</p>
                            </div>
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
        background-color: #121212;
    }

    .scroll-container {
        height: 100vh;
        overflow-y: scroll;
        scroll-snap-type: y mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;  /* Firefox */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
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
    }

    #intro .container {
        position: relative;
        z-index: 1;
    }

    .card {
        background-color: rgba(33, 37, 41, 0.8);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .z-index-1000 {
        z-index: 1000;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const sections = document.querySelectorAll('.scroll-section');
        const navItems = document.querySelectorAll('nav a');

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    const id = entry.target.getAttribute('id');
                    history.pushState(null, null, `#${id}`);
                    navItems.forEach(item => {
                        item.classList.remove('active');
                        if (item.getAttribute('href') === `#${id}`) {
                            item.classList.add('active');
                        }
                    });
                } else {
                    entry.target.classList.remove('active');
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    });
</script>
