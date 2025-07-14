@php
    $isActive = request()->routeIs($routeIs ?? $route) ? 'active' : '';
@endphp

<li class="{{ $isActive }}">
    <a href="{{ route($route) }}">
        <x-icon :name="$icon" />
        {{ __($label) ?? $label }}
    </a>
</li>
