@extends('layouts.admin')

@section('title', 'Discounts - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Discounts</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage promotions and sales</p>
        </div>
        <a href="{{ route('admin.discounts.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add Discount
        </a>
    </div>


    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Duration</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($discounts as $discount)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                            {{ $discount->discount_name }}
                            @if($discount->min_purchase > 0)
                                <div class="text-xs text-slate-500">Min. Purchase: Rp {{ number_format($discount->min_purchase, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300">
                            @if($discount->discount_type === 'PERCENT')
                                {{ $discount->discount_value }}%
                            @else
                                Rp {{ number_format($discount->discount_value, 0, ',', '.') }}
                            @endif
                        </td>
                         <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            <div class="flex flex-col text-xs">
                                <span>{{ \Carbon\Carbon::parse($discount->start_date)->format('M d, Y') }}</span>
                                <span class="text-slate-400">to</span>
                                <span>{{ \Carbon\Carbon::parse($discount->end_date)->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if(!$discount->is_active)
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">Inactive</span>
                            @elseif(\Carbon\Carbon::now()->lt($discount->start_date))
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Scheduled</span>
                            @elseif(\Carbon\Carbon::now()->gt($discount->end_date))
                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Expired</span>
                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.discounts.edit', $discount) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            No discounts found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-200 dark:border-gray-800">
            {{ $discounts->links() }}
        </div>
    </div>
</div>
@endsection
