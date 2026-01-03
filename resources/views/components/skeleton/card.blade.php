@props([
    'showImage' => true,
    'showAvatar' => false,
    'imageHeight' => 'h-48',
    'lines' => 3,
    'class' => ''
])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden {{ $class }}">
    {{-- Image placeholder --}}
    @if($showImage)
        <x-skeleton.base :class="$imageHeight . ' w-full'" rounded="none" {{ $attributes }} />
    @endif
    
    <div class="p-4 space-y-4">
        {{-- Avatar with title --}}
        @if($showAvatar)
            <div class="flex items-center space-x-3">
                <x-skeleton.avatar size="md" {{ $attributes }} />
                <div class="flex-1 space-y-2">
                    <x-skeleton.base class="h-4 w-1/2" {{ $attributes }} />
                    <x-skeleton.base class="h-3 w-1/3" {{ $attributes }} />
                </div>
            </div>
        @else
            {{-- Title --}}
            <x-skeleton.base class="h-6 w-3/4" {{ $attributes }} />
        @endif
        
        {{-- Content lines --}}
        <x-skeleton.text :lines="$lines" {{ $attributes }} />
        
        {{-- Optional slot for custom content --}}
        {{ $slot }}
    </div>
</div>
