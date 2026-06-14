@props(['active'])

@php
    $classes = ($active ?? false)
               ? 'inline-flex items-center px-3 py-2 border-b-2 border-black text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-black'
               : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
