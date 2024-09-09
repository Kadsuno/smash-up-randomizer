<x-layouts.backend.backendHeader />
    <div class="container-fluid pl-0">
        <div class="row">
            <div class="col-2 bg-dark">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar">
                    <ul class="nav nav-pills flex-column mb-auto text-center">
                      <li class="nav-item backend-nav" id="dashboard">
                        <a href="{{ route('dashboard') }}" class="nav-link sidebar-link" aria-current="page">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                      </li>
                      <li class="nav-item backend-nav mt-3" id="decks-manager">
                        <a href="{{ route('decks-manager') }}" class="nav-link sidebar-link" aria-current="page">
                            <i class="fa-solid fa-wrench"></i> Faction Manager                        
                        </a>
                      </li>
                    </ul>
                  </div>
            </div>
            <div class="col-10 mt-5">
                <main class="flex flex-1 container max-w-7xl mx-auto px-5 lg:px-40 space-x-5 mb-5">
                    {{ $slot }}
                </main>        
            </div>
        </div>
    </div>   
    <x-layouts.backend.backendFooter /> 
</body>
</html>