<x-layouts.backend.backendMain>
    <div class="container">
        <h1 class="mb-4">Edit Deck</h1>
        <form id="deckForm" action="{{ route('update-deck', $deck->name) }}" method="POST">
            @csrf
            <div id="step1" class="step">
                <h2>Step 1: Basic Information</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $deck->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="teaser" class="form-label">Teaser</label>
                    <div id="teaser"></div>
                    <input type="hidden" name="teaser" value="{{ old('teaser', $deck->teaser) }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <div id="description"></div>
                    <input type="hidden" name="description" value="{{ old('description', $deck->description) }}">
                </div>
                <button type="button" class="btn btn-primary next-step">Next</button>
            </div>

            <div id="step2" class="step">
                <h2>Step 2: Card Information</h2>
                <div class="mb-3">
                    <label for="cardsTeaser" class="form-label">Cards Teaser</label>
                    <div id="cardsTeaser"></div>
                    <input type="hidden" name="cardsTeaser" value="{{ old('cardsTeaser', $deck->cardsTeaser) }}">
                </div>
                <div class="mb-3">
                    <label for="actionTeaser" class="form-label">Action Teaser</label>
                    <div id="actionTeaser"></div>
                    <input type="hidden" name="actionTeaser" value="{{ old('actionTeaser', $deck->actionTeaser) }}">
                </div>
                <div class="mb-3">
                    <label for="actionList" class="form-label">Action List</label>
                    <div id="actionList"></div>
                    <input type="hidden" name="actionList" value="{{ old('actionList', $deck->actionList) }}">
                </div>
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
            </div>

            <div id="step3" class="step">
                <h2>Step 3: Gameplay Elements</h2>
                <div class="mb-3">
                    <label for="actions" class="form-label">Actions</label>
                    <div id="actions"></div>
                    <input type="hidden" name="actions" value="{{ old('actions', $deck->actions) }}">
                </div>
                <div class="mb-3">
                    <label for="characters" class="form-label">Characters</label>
                    <div id="characters"></div>
                    <input type="hidden" name="characters" value="{{ old('characters', $deck->characters) }}">
                </div>
                <div class="mb-3">
                    <label for="bases" class="form-label">Bases</label>
                    <div id="bases"></div>
                    <input type="hidden" name="bases" value="{{ old('bases', $deck->bases) }}">
                </div>
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
            </div>

            <div id="step4" class="step">
                <h2>Step 4: Additional Information</h2>
                <div class="mb-3">
                    <label for="clarifications" class="form-label">Clarifications</label>
                    <div id="clarifications"></div>
                    <input type="hidden" name="clarifications" value="{{ old('clarifications', $deck->clarifications) }}">
                </div>
                <div class="mb-3">
                    <label for="suggestionTeaser" class="form-label">Suggestion Teaser</label>
                    <div id="suggestionTeaser"></div>
                    <input type="hidden" name="suggestionTeaser" value="{{ old('suggestionTeaser', $deck->suggestionTeaser) }}">
                </div>
                <div class="mb-3">
                    <label for="synergy" class="form-label">Synergy</label>
                    <div id="synergy"></div>
                    <input type="hidden" name="synergy" value="{{ old('synergy', $deck->synergy) }}">
                </div>
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="button" class="btn btn-primary next-step">Next</button>
            </div>

            <div id="step5" class="step">
                <h2>Step 5: Final Details</h2>
                <div class="mb-3">
                    <label for="tips" class="form-label">Tips</label>
                    <div id="tips"></div>
                    <input type="hidden" name="tips" value="{{ old('tips', $deck->tips) }}">
                </div>
                <div class="mb-3">
                    <label for="mechanics" class="form-label">Mechanics</label>
                    <div id="mechanics"></div>
                    <input type="hidden" name="mechanics" value="{{ old('mechanics', $deck->mechanics) }}">
                </div>
                <div class="mb-3">
                    <label for="expansion" class="form-label">Expansion</label>
                    <input type="text" class="form-control" id="expansion" name="expansion" value="{{ old('expansion', $deck->expansion) }}">
                </div>
                <div class="mb-3">
                    <label for="effects" class="form-label">Effects</label>
                    <div id="effects"></div>
                    <input type="hidden" name="effects" value="{{ old('effects', $deck->effects) }}">
                </div>
                <div class="mb-3">
                    <label for="playstyle" class="form-label">Playstyle</label>
                    <div id="playstyle"></div>
                    <input type="hidden" name="playstyle" value="{{ old('playstyle', $deck->playstyle) }}">
                </div>
                <button type="button" class="btn btn-secondary prev-step">Previous</button>
                <button type="submit" class="btn btn-primary">Update Deck</button>
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
            const form = document.getElementById('deckForm');
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
                        editor.setData(document.querySelector(`input[name="${field}"]`).value);
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
