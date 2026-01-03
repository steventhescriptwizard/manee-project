@props([
    'showImage' => true,
    'imageSize' => 'w-16 h-16',
    'showActions' => true,
    'lines' => 2,
    'class' => ''
])

<div class="flex items-center space-x-4 p-4 bg-white dark:bg-gray-800 rounded-lg {{ $class }}">
    @if($showImage)
        <x-skeleton.base :class="$imageSize . ' flex-shrink-0'" rounded="lg" {{ $attributes }} />
    @endif
    
    <div class="flex-1 min-w-0 space-y-2">
        <x-skeleton.base class="h-5 w-3/4" {{ $attributes }} />
        @for($i = 1; $i < $lines; $i++)
            <x-skeleton.base class="h-4 w-{{ rand(40, 60) }}%" {{ $attributes }} />
        @endfor
    </div>
    
    @if($showActions)
        <div class="flex items-center space-x-2 flex-shrink-0">
            <x-skeleton.base class="h-8 w-8" rounded="lg" {{ $attributes }} />
            <x-skeleton.base class="h-8 w-8" rounded="lg" {{ $attributes }} />
        </div>
    @endif
</div>
