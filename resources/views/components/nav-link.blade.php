@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-50 text-blue-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition duration-150 ease-in-out'
            : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
