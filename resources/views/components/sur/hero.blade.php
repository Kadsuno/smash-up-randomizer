@props([
    'image' => null,
    'minClass' => 'min-h-[70vh] sm:min-h-[80vh]',
    'bgId' => null,
])

<section {{ $attributes->merge(['class' => 'relative w-full overflow-hidden']) }}>
    @if ($image)
        <div
            @if ($bgId) id="{{ $bgId }}" @endif
            class="bg-options hero-height {{ $minClass }}"
            style="background-image: url('{{ $image }}');"
        >
            <div class="pointer-events-none absolute inset-0 bg-linear-to-b from-black/45 via-black/10 to-zinc-950/85" aria-hidden="true"></div>
            <div class="relative z-10 mx-auto flex min-h-[inherit] w-full max-w-7xl flex-col justify-center px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </div>
    @else
        {{ $slot }}
    @endif
</section>
