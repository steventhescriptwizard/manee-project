@props([
    'size' => 'md',
    'class' => ''
])

@php
    $sizes = [
        'xs' => 'w-6 h-6',
        'sm' => 'w-8 h-8',
        'md' => 'w-10 h-10',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
        '2xl' => 'w-20 h-20',
    ];
@endphp

<x-skeleton.base 
    :class="($sizes[$size] ?? $sizes['md']) . ' ' . $class" 
    rounded="full" 
    {{ $attributes }}
/>
