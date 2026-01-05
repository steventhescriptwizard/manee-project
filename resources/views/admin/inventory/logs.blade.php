@extends('layouts.admin')

@section('title', 'Stock Movement Logs - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Stock Movement Logs</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Complete history of all stock changes</p>
        </div>
        <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-gray-700 transition-colors">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            Back to Inventory
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Date & Time</th>
                        <th class="px-6 py-4">Product / Variant</th>
                        <th class="px-6 py-4">Warehouse</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Quantity</th>
                        <th class="px-6 py-4">Reference</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($movements as $movement)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-xs">
                            {{ $movement->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 dark:text-white">
                                {{ $movement->product->product_name }}
                            </div>
                            @if($movement->variant)
                                <div class="text-xs text-blue-600 font-medium">
                                    {{ $movement->variant->color ?? '' }} {{ $movement->variant->size ?? '' }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $movement->warehouse->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($movement->type === 'IN')
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Stock In</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Stock Out</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                            {{ $movement->quantity }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-xs">
                            {{ ucfirst($movement->reference_type) }}
                            @if($movement->reference_id)
                                <span class="text-slate-400">#{{ $movement->reference_id }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $movement->user->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $movement->notes ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            No movement records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-200 dark:border-gray-800">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection
