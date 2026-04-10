<x-layouts.backend.backendHeader />

    <div class="flex min-h-screen pt-14">

        {{-- Sidebar --}}
        <aside id="sidebar" class="sidebar fixed top-14 bottom-0 z-40 flex flex-col border-r border-white/6 bg-zinc-950 transition-[width] duration-200 ease-in-out" style="width: 220px;">

            {{-- Collapse toggle --}}
            <div class="flex items-center justify-between border-b border-white/6 px-3 py-2.5">
                <span id="sidebar-label" class="text-[0.6rem] font-bold uppercase tracking-widest text-zinc-600">Navigation</span>
                <button
                    id="sidebarCollapse"
                    type="button"
                    class="flex h-7 w-7 items-center justify-center rounded-lg text-zinc-600 transition hover:bg-white/5 hover:text-zinc-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                    aria-label="Toggle sidebar"
                >
                    <i id="collapseIcon" class="fas fa-chevron-left text-xs" aria-hidden="true"></i>
                </button>
            </div>

            {{-- Nav links --}}
            <nav class="flex flex-col gap-1 p-2 pt-3">
                @php
                    $links = [
                        ['route' => 'dashboard',     'icon' => 'fa-house',  'label' => __('backend.nav_dashboard')],
                        ['route' => 'decks-manager', 'icon' => 'fa-layer-group', 'label' => __('backend.nav_faction_manager')],
                    ];
                @endphp
                @foreach($links as $link)
                @php $active = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}"
                    class="sidebar-link group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition duration-150 {{ $active ? 'bg-indigo-500/10 text-indigo-300' : 'text-zinc-500 hover:bg-white/5 hover:text-zinc-200' }}"
                >
                    <i class="fa-solid {{ $link['icon'] }} w-4 shrink-0 text-center text-sm {{ $active ? 'text-indigo-400' : 'text-zinc-600 group-hover:text-zinc-400' }}" aria-hidden="true"></i>
                    <span class="sidebar-text truncate">{{ $link['label'] }}</span>
                </a>
                @endforeach
            </nav>

        </aside>

        {{-- Main content — offset by sidebar width --}}
        <div id="content" class="min-w-0 flex-1 p-6 pt-8 transition-[margin] duration-200 ease-in-out" style="margin-left: 220px;">
            <main class="mx-auto w-full max-w-5xl">
                {{ $slot }}
            </main>
        </div>

    </div>

    <x-layouts.backend.backendFooter />

    <script>
    (function () {
        var sidebar   = document.getElementById('sidebar');
        var content   = document.getElementById('content');
        var btn       = document.getElementById('sidebarCollapse');
        var icon      = document.getElementById('collapseIcon');
        var label     = document.getElementById('sidebar-label');
        var texts     = document.querySelectorAll('.sidebar-text');
        var collapsed = localStorage.getItem('sidebar') === 'collapsed';

        function apply(instant) {
            if (instant) {
                sidebar.style.transition = 'none';
                content.style.transition = 'none';
            }
            if (collapsed) {
                sidebar.style.width = '64px';
                content.style.marginLeft = '64px';
                icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                label.classList.add('hidden');
                texts.forEach(function (t) { t.classList.add('hidden'); });
            } else {
                sidebar.style.width = '220px';
                content.style.marginLeft = '220px';
                icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                label.classList.remove('hidden');
                texts.forEach(function (t) { t.classList.remove('hidden'); });
            }
            if (instant) {
                // Re-enable transitions after paint
                requestAnimationFrame(function () {
                    sidebar.style.transition = '';
                    content.style.transition = '';
                });
            }
        }

        apply(true);

        btn.addEventListener('click', function () {
            collapsed = !collapsed;
            localStorage.setItem('sidebar', collapsed ? 'collapsed' : 'expanded');
            apply(false);
        });
    })();
    </script>

</body>
</html>
