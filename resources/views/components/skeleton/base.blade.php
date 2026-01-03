@props([
    'class' => '',
    'rounded' => 'md',
    'animation' => 'pulse' // pulse, shimmer, wave
])

@php
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        '2xl' => 'rounded-2xl',
        'full' => 'rounded-full',
    ];

    $animationClasses = [
        'pulse' => 'animate-pulse',
        'shimmer' => 'skeleton-shimmer',
        'wave' => 'skeleton-wave',
    ];
@endphp

<div {{ $attributes->merge([
    'class' => 'bg-gray-200 dark:bg-gray-700 ' . 
               ($roundedClasses[$rounded] ?? 'rounded-md') . ' ' . 
               ($animationClasses[$animation] ?? 'animate-pulse') . ' ' . 
               $class
]) }}></div>
