@props(['variant' => 'primary'])

@php
    $classes = 'btn ';
    $classes .= match($variant) {
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        default => 'btn-primary',
    };
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
