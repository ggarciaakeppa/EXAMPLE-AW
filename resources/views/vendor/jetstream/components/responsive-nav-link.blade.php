@props(['active'])

@php
$classes = ($active ?? false)
            ? ''
            : 'text-gray-600';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
