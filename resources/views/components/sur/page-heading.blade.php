@props(['subtitle' => null])

<header {{ $attributes->merge(['class' => 'mb-10 text-center md:mb-12']) }}>
    <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
        {{ $slot }}
    </h1>
    @if ($subtitle)
        <p class="mx-auto mt-3 max-w-2xl text-sm text-zinc-400 sm:text-base">{{ $subtitle }}</p>
    @endif
</header>
