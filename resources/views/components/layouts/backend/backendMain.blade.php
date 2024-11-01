<x-layouts.backend.backendHeader />
    <div class="d-flex">
        <div id="sidebar" class="bg-dark text-white sidebar mt-5">
            <div class="sidebar-header d-flex justify-content-between align-items-center p-3">
                <button id="sidebarCollapse" class="btn btn-secondary rounded-circle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <ul class="nav flex-column mb-auto p-3">
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard') }}" class="nav-link sidebar-link d-flex align-items-center justify-content-center btn {{ request()->routeIs('dashboard') ? 'btn-primary' : 'btn-secondary' }} rounded-pill">
                        <i class="fa-solid fa-house icon-margin"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('decks-manager') }}" class="nav-link sidebar-link d-flex align-items-center justify-content-center btn {{ request()->routeIs('decks-manager') ? 'btn-primary' : 'btn-secondary' }} rounded-pill">
                        <i class="fa-solid fa-wrench icon-margin"></i>
                        <span class="menu-text">Faction Manager</span>
                    </a>
                </li>
            </ul>
        </div>
        <div id="content" class="flex-grow-1 p-4 mt-5">
            <main class="container-fluid">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-layouts.backend.backendFooter />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebarCollapse = document.getElementById('sidebarCollapse');
            var sidebar = document.getElementById('sidebar');
            var content = document.getElementById('content');
            var menuTexts = document.querySelectorAll('.menu-text');
            var sidebarLinks = document.querySelectorAll('.sidebar-link');
            var icons = document.querySelectorAll('.icon-margin');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                content.classList.toggle('active');
                menuTexts.forEach(function(text) {
                    text.classList.toggle('d-none');
                });
                sidebarLinks.forEach(function(link) {
                    link.classList.toggle('justify-content-center');
                    link.classList.toggle('justify-content-start');
                });
                icons.forEach(function(icon) {
                    icon.classList.toggle('me-0');
                });
                
                // Store sidebar state in localStorage
                localStorage.setItem('sidebarState', sidebar.classList.contains('active') ? 'collapsed' : 'expanded');

                // Toggle arrow direction
                var arrow = sidebarCollapse.querySelector('i');
                arrow.classList.toggle('fa-chevron-left');
                arrow.classList.toggle('fa-chevron-right');
            }

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', toggleSidebar);
            }

            // Check and apply saved sidebar state on page load
            var sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'collapsed') {
                toggleSidebar();
            } else {
                sidebarLinks.forEach(function(link) {
                    link.classList.add('justify-content-start');
                });
            }

            sidebarLinks.forEach(function(link) {
                link.addEventListener('mouseenter', function() {
                    this.classList.add('animate__animated', 'animate__pulse');
                });
                link.addEventListener('mouseleave', function() {
                    this.classList.remove('animate__animated', 'animate__pulse');
                });
            });
        });
    </script>
    <style>
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            transition: all 0.3s;
            position: relative;
        }
        .sidebar.active {
            min-width: 80px;
            max-width: 80px;
        }
        #content {
            width: 100%;
            transition: all 0.3s;
        }
        #content.active {
            margin-left: -170px;
        }
        .sidebar-link {
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar-link:hover {
            color: #17a2b8;
            background-color: rgba(255,255,255,0.2);
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .sidebar-link.btn-primary {
            color: #fff;
            background-color: #0056b3;
        }
        .sidebar-link.btn-secondary {
            color: #fff;
            background-color: #6c757d;
        }
        .sidebar-link.btn-primary:hover,
        .sidebar-link.btn-secondary:hover {
            filter: brightness(110%);
        }
        #sidebarCollapse {
            position: absolute;
            top: 50%;
            right: -20px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .sidebar-link i {
            min-width: 20px;
            text-align: center;
        }
        .icon-margin {
            margin-right: 0.5rem;
        }
        .sidebar.active .icon-margin {
            margin-right: 0;
        }
    </style>
</body>
</html>