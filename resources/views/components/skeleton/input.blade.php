@props([
    'label' => true,
    'class' => ''
])

<div class="space-y-1 {{ $class }}">
    @if($label)
        <x-skeleton.base class="h-4 w-24 mb-2" {{ $attributes }} />
    @endif
    <x-skeleton.base class="h-10 w-full" rounded="lg" {{ $attributes }} />
</div>
