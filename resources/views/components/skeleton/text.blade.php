@props([
    'lines' => 3,
    'class' => '',
    'lastLineWidth' => '75%'
])

<div class="space-y-2 {{ $class }}">
    @for ($i = 0; $i < $lines; $i++)
        <x-skeleton.base 
            class="h-4" 
            :style="$i === $lines - 1 ? 'width: ' . $lastLineWidth : 'width: 100%'" 
            {{ $attributes }}
        />
    @endfor
</div>
