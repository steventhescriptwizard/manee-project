@props([
    'size' => 'md',
    'fullWidth' => false,
    'class' => ''
])

@php
    $sizes = [
        'xs' => 'h-6 w-16',
        'sm' => 'h-8 w-20',
        'md' => 'h-10 w-24',
        'lg' => 'h-12 w-32',
        'xl' => 'h-14 w-40',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    if ($fullWidth) {
        $sizeClass = preg_replace('/w-\d+/', 'w-full', $sizeClass);
    }
@endphp

<x-skeleton.base :class="$sizeClass . ' ' . $class" rounded="lg" {{ $attributes }} />
