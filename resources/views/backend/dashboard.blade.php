<x-layouts.backend.backendMain>
    <div class="animate__animated animate__fadeIn text-zinc-100">
        <h1 class="mb-8 text-center text-3xl font-bold text-white sm:text-4xl">
            {{ __('backend.dashboard_header') }}
        </h1>
        <div class="mb-8 max-w-3xl">
            <p class="mb-4 text-lg leading-relaxed text-zinc-300">
                {{ __('backend.dashboard_body') }}
            </p>
            <p class="text-zinc-400">
                {{ __('backend.dashboard_welcome') }}
            </p>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <div class="sur-card border-white/10">
                <h2 class="mb-2 text-lg font-semibold text-cyan-300">{{ __('backend.dashboard_quick_stats') }}</h2>
                <p class="mb-4 text-sm text-zinc-400">{{ __('backend.dashboard_stats_description') }}</p>
                <a href="#" class="sur-btn-ghost min-h-10 text-sm">{{ __('backend.view_stats') }}</a>
            </div>
            <div class="sur-card border-white/10">
                <h2 class="mb-2 text-lg font-semibold text-cyan-300">{{ __('backend.dashboard_recent_activity') }}</h2>
                <p class="mb-4 text-sm text-zinc-400">{{ __('backend.dashboard_activity_description') }}</p>
                <a href="#" class="sur-btn-ghost min-h-10 text-sm">{{ __('backend.view_activity') }}</a>
            </div>
            <div class="sur-card border-white/10">
                <h2 class="mb-2 text-lg font-semibold text-cyan-300">{{ __('backend.dashboard_quick_actions') }}</h2>
                <p class="mb-4 text-sm text-zinc-400">{{ __('backend.dashboard_actions_description') }}</p>
                <a href="#" class="sur-btn-ghost min-h-10 text-sm">{{ __('backend.perform_action') }}</a>
            </div>
        </div>
    </div>
</x-layouts.backend.backendMain>
