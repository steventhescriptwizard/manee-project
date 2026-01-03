@props([
    'showBadge' => true,
    'class' => ''
])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden group {{ $class }}">
    {{-- Product Image --}}
    <div class="relative aspect-square">
        <x-skeleton.base class="w-full h-full" rounded="none" {{ $attributes }} />
        
        @if($showBadge)
            {{-- Badge placeholder --}}
            <div class="absolute top-3 left-3">
                <x-skeleton.base class="h-6 w-16" rounded="full" {{ $attributes }} />
            </div>
        @endif
        
        {{-- Quick action buttons placeholder --}}
        <div class="absolute top-3 right-3 space-y-2">
            <x-skeleton.base class="h-8 w-8" rounded="full" {{ $attributes }} />
            <x-skeleton.base class="h-8 w-8" rounded="full" {{ $attributes }} />
        </div>
    </div>
    
    {{-- Product Info --}}
    <div class="p-4 space-y-3">
        {{-- Category --}}
        <x-skeleton.base class="h-3 w-1/4" {{ $attributes }} />
        
        {{-- Product name --}}
        <x-skeleton.base class="h-5 w-full" {{ $attributes }} />
        <x-skeleton.base class="h-5 w-2/3" {{ $attributes }} />
        
        {{-- Price --}}
        <div class="flex items-center justify-between pt-2">
            <x-skeleton.base class="h-6 w-24" {{ $attributes }} />
            <x-skeleton.base class="h-4 w-16" {{ $attributes }} />
        </div>
        
        {{-- Rating --}}
        <div class="flex items-center space-x-1">
            @for($i = 0; $i < 5; $i++)
                <x-skeleton.base class="h-4 w-4" rounded="sm" {{ $attributes }} />
            @endfor
            <x-skeleton.base class="h-3 w-8 ml-2" {{ $attributes }} />
        </div>
        
        {{-- Add to cart button --}}
        <x-skeleton.base class="h-10 w-full mt-4" rounded="lg" {{ $attributes }} />
    </div>
</div>
