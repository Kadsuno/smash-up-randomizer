@props([
    'routeName',
    'routes' => null,
    'label',
    'mobile' => false,
])

@php
    $check = $routes ?? [$routeName];
    $active = false;
    foreach ($check as $r) {
        if (request()->routeIs($r)) {
            $active = true;
            break;
        }
    }
@endphp

<a
    href="{{ route($routeName) }}"
    @class([
        'focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60',
        'sur-nav-pill' => ! $mobile,
        'sur-nav-pill-active' => ! $mobile && $active,
        'sur-nav-pill-idle' => ! $mobile && ! $active,
        'sur-nav-mobile-link' => $mobile,
        'sur-nav-mobile-link-active' => $mobile && $active,
        'sur-nav-mobile-link-idle' => $mobile && ! $active,
    ])
>
    {{ $label }}
</a>
