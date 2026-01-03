@props([
    'columns' => 5,
    'showCheckbox' => true,
    'showAvatar' => false,
    'class' => ''
])

<tr class="border-b border-gray-200 dark:border-gray-700 {{ $class }}">
    @if($showCheckbox)
        <td class="px-4 py-3">
            <x-skeleton.base class="h-4 w-4" rounded="sm" {{ $attributes }} />
        </td>
    @endif
    
    @if($showAvatar)
        <td class="px-4 py-3">
            <div class="flex items-center space-x-3">
                <x-skeleton.avatar size="sm" {{ $attributes }} />
                <div class="space-y-1">
                    <x-skeleton.base class="h-4 w-24" {{ $attributes }} />
                    <x-skeleton.base class="h-3 w-16" {{ $attributes }} />
                </div>
            </div>
        </td>
        @php $columns-- @endphp
    @endif
    
    @for($i = 0; $i < $columns; $i++)
        <td class="px-4 py-3">
            <x-skeleton.base class="h-4 w-full max-w-[{{ rand(60, 100) }}%]" {{ $attributes }} />
        </td>
    @endfor
</tr>
