@extends('layouts.admin')

@section('title', 'Manage Taxes')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Taxes</h1>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Manage tax rates applicable to products.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <a href="{{ route('admin.taxes.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
            <span class="material-symbols-outlined text-xl mr-2">add</span>
            Add Tax
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-slate-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-gray-700">
            <thead class="bg-slate-50 dark:bg-gray-900/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Rate</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-4 text-right">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                @forelse($taxes as $tax)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-white">
                            {{ $tax->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                            {{ $tax->rate }}%
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300 capitalize">
                            {{ $tax->type }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($tax->is_active)
                                <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Active</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-400 ring-1 ring-inset ring-slate-500/10">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.taxes.edit', $tax) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</a>
                                <form action="{{ route('admin.taxes.destroy', $tax) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 ml-2">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-3">attach_money</span>
                                <p class="text-slate-500 dark:text-slate-400 text-sm">No taxes configured yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($taxes->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900/50">
            {{ $taxes->links() }}
        </div>
    @endif
</div>
@endsection
