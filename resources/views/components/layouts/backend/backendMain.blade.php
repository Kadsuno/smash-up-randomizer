<x-layouts.backend.backendHeader />
    <div class="flex min-h-screen pt-14">
        <aside id="sidebar" class="sidebar relative min-h-[calc(100vh-3.5rem)] w-[250px] shrink-0 border-r border-white/10 bg-zinc-900 transition-[width] duration-300">
            <div class="flex items-center justify-end border-b border-white/10 p-3">
                <button id="sidebarCollapse" type="button" class="absolute right-[-1.25rem] top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-zinc-800 text-zinc-200 shadow-lg transition hover:border-indigo-500/40 hover:text-indigo-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60" aria-label="Toggle sidebar">
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                </button>
            </div>
            <ul class="flex flex-col gap-2 p-3">
                <li>
                    <a id="dashboard" href="{{ route('dashboard') }}" class="sidebar-link flex min-h-11 items-center justify-start rounded-full border border-transparent px-4 py-2 text-sm font-medium transition duration-200 {{ request()->routeIs('dashboard') ? 'border-indigo-500/40 bg-indigo-500/15 text-indigo-200' : 'bg-zinc-800/80 text-zinc-200 hover:border-white/10 hover:bg-white/5' }}">
                        <i class="fa-solid fa-house icon-margin min-w-[1.25rem] text-center" aria-hidden="true"></i>
                        <span class="menu-text">{{ __('backend.nav_dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a id="decks-manager" href="{{ route('decks-manager') }}" class="sidebar-link flex min-h-11 items-center justify-start rounded-full border border-transparent px-4 py-2 text-sm font-medium transition duration-200 {{ request()->routeIs('decks-manager') ? 'border-indigo-500/40 bg-indigo-500/15 text-indigo-200' : 'bg-zinc-800/80 text-zinc-200 hover:border-white/10 hover:bg-white/5' }}">
                        <i class="fa-solid fa-wrench icon-margin min-w-[1.25rem] text-center" aria-hidden="true"></i>
                        <span class="menu-text">{{ __('backend.nav_faction_manager') }}</span>
                    </a>
                </li>
            </ul>
        </aside>
        <div id="content" class="content min-w-0 flex-1 p-4 pt-6 transition-all duration-300">
            <main class="mx-auto w-full max-w-7xl">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-layouts.backend.backendFooter />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebarCollapse = document.getElementById('sidebarCollapse');
            var sidebar = document.getElementById('sidebar');
            var menuTexts = document.querySelectorAll('.menu-text');
            var sidebarLinks = document.querySelectorAll('.sidebar-link');
            var icons = document.querySelectorAll('.icon-margin');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                menuTexts.forEach(function (text) {
                    text.classList.toggle('hidden');
                });
                sidebarLinks.forEach(function (link) {
                    link.classList.toggle('justify-center');
                    link.classList.toggle('justify-start');
                });
                icons.forEach(function (icon) {
                    icon.classList.toggle('mr-0');
                });

                localStorage.setItem('sidebarState', sidebar.classList.contains('active') ? 'collapsed' : 'expanded');

                var arrow = sidebarCollapse.querySelector('i');
                arrow.classList.toggle('fa-chevron-left');
                arrow.classList.toggle('fa-chevron-right');
            }

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', toggleSidebar);
            }

            var sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'collapsed') {
                toggleSidebar();
            } else {
                sidebarLinks.forEach(function (link) {
                    link.classList.add('justify-start');
                });
            }

            sidebarLinks.forEach(function (link) {
                link.addEventListener('mouseenter', function () {
                    this.classList.add('animate__animated', 'animate__pulse');
                });
                link.addEventListener('mouseleave', function () {
                    this.classList.remove('animate__animated', 'animate__pulse');
                });
            });
        });
    </script>
    <style>
        .sidebar {
            min-width: 250px;
            max-width: 250px;
        }
        .sidebar.active {
            min-width: 80px;
            max-width: 80px;
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
