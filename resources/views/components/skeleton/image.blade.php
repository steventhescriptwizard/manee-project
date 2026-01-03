@props([
    'aspectRatio' => 'square', // square, video, portrait, wide
    'class' => ''
])

@php
    $aspectClasses = [
        'square' => 'aspect-square',
        'video' => 'aspect-video',
        'portrait' => 'aspect-[3/4]',
        'wide' => 'aspect-[16/9]',
    ];
@endphp

<x-skeleton.base 
    :class="($aspectClasses[$aspectRatio] ?? 'aspect-square') . ' w-full ' . $class" 
    rounded="lg"
    {{ $attributes }}
/>
