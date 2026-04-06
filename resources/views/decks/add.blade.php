<x-layouts.backend.backendMain>
    <div class="mx-auto max-w-4xl px-4 py-4 text-zinc-100">
        <h1 class="mb-6 text-2xl font-bold text-white">Create Faction</h1>
        <form id="factionForm" action="{{ route('store-deck') }}" method="POST">
            @csrf
            <div id="step1" class="step">
                <h2>Step 1: Basic Information</h2>
                <div class="mb-3">
                    <label for="name" class="mb-2 block text-sm font-medium text-zinc-300">Name</label>
                    <input type="text" class="sur-input" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="teaser" class="mb-2 block text-sm font-medium text-zinc-300">Teaser</label>
                    <div id="teaser"></div>
                    <input type="hidden" name="teaser">
                </div>
                <div class="mb-3">
                    <label for="description" class="mb-2 block text-sm font-medium text-zinc-300">Description</label>
                    <div id="description"></div>
                    <input type="hidden" name="description">
                </div>
                <button type="button" class="sur-btn-primary next-step">Next</button>
            </div>

            <div id="step2" class="step">
                <h2>Step 2: Card Information</h2>
                <div class="mb-3">
                    <label for="cardsTeaser" class="mb-2 block text-sm font-medium text-zinc-300">Cards Teaser</label>
                    <div id="cardsTeaser"></div>
                    <input type="hidden" name="cardsTeaser">
                </div>
                <div class="mb-3">
                    <label for="actionTeaser" class="mb-2 block text-sm font-medium text-zinc-300">Action Teaser</label>
                    <div id="actionTeaser"></div>
                    <input type="hidden" name="actionTeaser">
                </div>
                <div class="mb-3">
                    <label for="actionList" class="mb-2 block text-sm font-medium text-zinc-300">Action List</label>
                    <div id="actionList"></div>
                    <input type="hidden" name="actionList">
                </div>
                <button type="button" class="sur-btn-secondary prev-step">Previous</button>
                <button type="button" class="sur-btn-primary next-step">Next</button>
            </div>

            <div id="step3" class="step">
                <h2>Step 3: Gameplay Elements</h2>
                <div class="mb-3">
                    <label for="actions" class="mb-2 block text-sm font-medium text-zinc-300">Actions</label>
                    <div id="actions"></div>
                    <input type="hidden" name="actions">
                </div>
                <div class="mb-3">
                    <label for="characters" class="mb-2 block text-sm font-medium text-zinc-300">Characters</label>
                    <div id="characters"></div>
                    <input type="hidden" name="characters">
                </div>
                <div class="mb-3">
                    <label for="bases" class="mb-2 block text-sm font-medium text-zinc-300">Bases</label>
                    <div id="bases"></div>
                    <input type="hidden" name="bases">
                </div>
                <button type="button" class="sur-btn-secondary prev-step">Previous</button>
                <button type="button" class="sur-btn-primary next-step">Next</button>
            </div>

            <div id="step4" class="step">
                <h2>Step 4: Additional Information</h2>
                <div class="mb-3">
                    <label for="clarifications" class="mb-2 block text-sm font-medium text-zinc-300">Clarifications</label>
                    <div id="clarifications"></div>
                    <input type="hidden" name="clarifications">
                </div>
                <div class="mb-3">
                    <label for="suggestionTeaser" class="mb-2 block text-sm font-medium text-zinc-300">Suggestion Teaser</label>
                    <div id="suggestionTeaser"></div>
                    <input type="hidden" name="suggestionTeaser">
                </div>
                <div class="mb-3">
                    <label for="synergy" class="mb-2 block text-sm font-medium text-zinc-300">Synergy</label>
                    <div id="synergy"></div>
                    <input type="hidden" name="synergy">
                </div>
                <button type="button" class="sur-btn-secondary prev-step">Previous</button>
                <button type="button" class="sur-btn-primary next-step">Next</button>
            </div>

            <div id="step5" class="step">
                <h2>Step 5: Final Details</h2>
                <div class="mb-3">
                    <label for="tips" class="mb-2 block text-sm font-medium text-zinc-300">Tips</label>
                    <div id="tips"></div>
                    <input type="hidden" name="tips">
                </div>
                <div class="mb-3">
                    <label for="mechanics" class="mb-2 block text-sm font-medium text-zinc-300">Mechanics</label>
                    <div id="mechanics"></div>
                    <input type="hidden" name="mechanics">
                </div>
                <div class="mb-3">
                    <label for="expansion" class="mb-2 block text-sm font-medium text-zinc-300">Expansion</label>
                    <input type="text" class="sur-input" id="expansion" name="expansion">
                </div>
                <div class="mb-3">
                    <label for="effects" class="mb-2 block text-sm font-medium text-zinc-300">Effects</label>
                    <div id="effects"></div>
                    <input type="hidden" name="effects">
                </div>
                <div class="mb-3">
                    <label for="playstyle" class="mb-2 block text-sm font-medium text-zinc-300">Playstyle</label>
                    <div id="playstyle"></div>
                    <input type="hidden" name="playstyle">
                </div>
                <button type="button" class="sur-btn-secondary prev-step">Previous</button>
                <button type="submit" class="sur-btn-primary">Create Faction</button>
            </div>
        </form>
    </div>

    <style>
        .step {
            display: none;
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .step.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }
        /* Add this to ensure text in CKEditor is visible */
        .ck-editor__editable {
            color: black !important;
            background-color: white !important;
        }
    </style>

    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('factionForm');
            const steps = form.querySelectorAll('.step');
            const nextButtons = form.querySelectorAll('.next-step');
            const prevButtons = form.querySelectorAll('.prev-step');

            let currentStep = 0;

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    if (index === stepIndex) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });
            }

            function animateTransition(from, to) {
                from.style.animation = 'slideOutLeft 0.5s forwards';
                to.style.animation = 'slideInRight 0.5s forwards';
                
                setTimeout(() => {
                    from.classList.remove('active');
                    to.classList.add('active');
                    from.style.animation = '';
                    to.style.animation = '';
                }, 500);
            }

            nextButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        animateTransition(steps[currentStep], steps[currentStep + 1]);
                        currentStep++;
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep > 0) {
                        animateTransition(steps[currentStep], steps[currentStep - 1]);
                        currentStep--;
                    }
                });
            });

            showStep(currentStep);

            // Initialize CKEditor for each textarea
            const editorFields = [
                'teaser', 'description', 'cardsTeaser', 'actionTeaser', 'actionList',
                'actions', 'characters', 'bases', 'clarifications', 'suggestionTeaser',
                'synergy', 'tips', 'mechanics', 'effects', 'playstyle'
            ];

            editorFields.forEach(field => {
                ClassicEditor
                    .create(document.getElementById(field), {
                        // Add custom configuration to ensure text is visible
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                            ]
                        }
                    })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            document.querySelector(`input[name="${field}"]`).value = editor.getData();
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>

    <style>
        @keyframes slideOutLeft {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(-50px); opacity: 0; }
        }

        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</x-layouts.backend.backendMain>
