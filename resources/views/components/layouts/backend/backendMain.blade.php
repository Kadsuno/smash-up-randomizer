<x-layouts.backend.backendHeader />
    <div class="container-fluid pl-0">
        <div class="row">
            <div class="col-2 bg-dark border-top">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar">
                    <ul class="nav nav-pills flex-column mb-auto">
                      <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link text-white sidebar-link" aria-current="page">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('decks-manager') }}" class="nav-link text-white sidebar-link" aria-current="page">
                            <i class="fa-solid fa-wrench"></i> Decks Manager                        
                        </a>
                      </li>
                    </ul>
                  </div>
            </div>
            <div class="col-10">
                <main class="flex flex-1 container max-w-7xl mx-auto px-5 lg:px-40 space-x-5 mb-5">
                    {{ $slot }}
                </main>        
            </div>
        </div>
    
    </div>    
<x-layouts.footer />
</body>
</html>