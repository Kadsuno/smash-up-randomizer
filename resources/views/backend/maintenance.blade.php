<x-layouts.backend.backendMain>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">{{ __('backend.maintenance_title') }}</h1>
    <p class="mt-1 text-sm text-zinc-500">{{ __('backend.maintenance_subtitle') }}</p>
</div>

<div class="rounded-xl border border-amber-500/20 bg-amber-900/10 px-4 py-3 text-sm text-amber-200">
    {{ __('backend.maintenance_warning') }}
</div>

<ul class="mt-6 flex flex-col gap-3">
    @foreach($commands as $item)
    <li class="rounded-xl border border-white/6 bg-zinc-900/60 p-4">
        <code class="block break-all rounded-lg bg-zinc-950/80 px-3 py-2 text-sm text-indigo-300">{{ $item['command'] }}</code>
        <p class="mt-2 text-sm text-zinc-400">{{ $item['description'] }}</p>
    </li>
    @endforeach
</ul>

</x-layouts.backend.backendMain>
