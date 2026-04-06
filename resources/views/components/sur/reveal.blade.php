@props(['delay' => 0])

<div
    x-data="{ inView: false }"
    x-intersect.once="inView = true"
    x-bind:class="inView ? 'sur-reveal sur-reveal--in' : 'sur-reveal'"
    @if ((int) $delay > 0)
        style="--sur-reveal-delay: {{ (int) $delay }}ms"
    @endif
    {{ $attributes }}
>
    {{ $slot }}
</div>
