@props(['padded' => true, 'narrow' => false])

@php
    $py = $padded ? 'py-12 md:py-16 lg:py-20' : '';
@endphp

<section {{ $attributes->merge(['class' => trim($py)]) }}>
    <x-sur.container :narrow="$narrow">
        {{ $slot }}
    </x-sur.container>
</section>
