<x-layouts.backend.backendMain>
    <div class="container animate__animated animate__fadeIn">
        <h1 class="mb-4 text-white text-center animate__animated animate__slideInDown">Faction Manager</h1>

        <div class="row mb-4">
            <div class="col-md-6">
                <!-- Add Faction Button -->
                <a href="{{ route('add-deck') }}" class="btn btn-light btn-lg mb-3 animate__animated animate__pulse">
                    <i class="fas fa-plus"></i> Add Faction
                </a>
            </div>
            <div class="col-md-6">
                <!-- CSV Import Form -->
                <form action="{{ route('add-deck-csv') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <div class="input-group">
                        <input type="file" class="form-control" name="csv" accept=".csv">
                        <button class="btn btn-outline-light" type="submit">Import CSV</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Factions List -->
        <div class="card bg-dark text-white animate__animated animate__fadeInUp">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($decks as $deck)
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                    <td>{{ $deck->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('edit-deck', $deck->name) }}" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('delete-decks', $deck->name) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Sind Sie sicher, dass Sie diese Fraktion löschen möchten?')" data-bs-toggle="tooltip" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate__animated {
            animation-duration: 0.5s;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(255,255,255,0.1);
            transition: background-color 0.3s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</x-layouts.backend.backendMain>
