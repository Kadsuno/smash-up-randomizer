@props(['narrow' => false])

@php
    $max = $narrow ? 'max-w-3xl' : 'max-w-7xl';
@endphp

<div {{ $attributes->merge(['class' => 'mx-auto w-full px-4 sm:px-6 lg:px-8 ' . $max]) }}>
    {{ $slot }}
</div>
