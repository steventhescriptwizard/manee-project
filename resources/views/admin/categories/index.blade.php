@extends('layouts.admin')

@section('title', 'Categories - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Categories</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Organize your products hierarchically</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add Category
        </a>
    </div>


    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Parent</th>
                        <th class="px-6 py-4">Products</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            {{ $category->slug }}
                        </td>
                        <td class="px-6 py-4">
                            @if($category->parent)
                                <span class="bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded text-xs">
                                    {{ $category->parent->name }}
                                </span>
                            @else
                                <span class="text-slate-400 text-xs italic">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-medium">
                                {{ $category->products_count }}
                            </span>
                        </td>
                         <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Active</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
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
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            No categories found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-slate-200 dark:border-gray-800">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
