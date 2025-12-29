@extends('layouts.admin')

@section('title', 'Manage Reviews - Maneé Admin')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Product Reviews</h1>
    </div>


    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-gray-800/50 border-b border-slate-200 dark:border-gray-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">User & Product</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Rating & Review</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Images</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $review->user->name }}</span>
                                <span class="text-xs text-slate-500 mb-1 leading-none">{{ $review->user->email }}</span>
                                <a href="{{ route('admin.products.show', $review->product->id) }}" class="text-xs font-medium text-blue-600 hover:underline">
                                    {{ $review->product->product_name }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1 max-w-md">
                                <div class="flex text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-outlined text-sm {{ $i <= $review->rating ? 'fill-1' : '' }}">star</span>
                                    @endfor
                                </div>
                                @if($review->title)
                                    <span class="font-bold text-sm text-slate-900 dark:text-white leading-tight">{{ $review->title }}</span>
                                @endif
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed italic">"{{ $review->content }}"</p>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $review->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center -space-x-2">
                                @forelse($review->images as $img)
                                    <div class="size-8 rounded-lg border-2 border-white dark:border-gray-900 overflow-hidden bg-slate-100">
                                        <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                                    </div>
                                @empty
                                    <span class="text-[10px] text-slate-400">No images</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="size-2 rounded-full {{ $review->is_published ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                    <span class="text-xs font-medium {{ $review->is_published ? 'text-emerald-600' : 'text-slate-500' }}">
                                        {{ $review->is_published ? 'Published' : 'Hidden' }}
                                    </span>
                                </div>
                                @if($review->is_verified)
                                <div class="flex items-center gap-1.5 text-blue-600">
                                    <span class="material-symbols-outlined text-xs">verified</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider">Verified Purchase</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_published" value="{{ $review->is_published ? 0 : 1 }}">
                                    <button type="submit" class="p-2 {{ $review->is_published ? 'text-slate-500 hover:text-slate-900' : 'text-emerald-500 hover:text-emerald-700' }} transition-colors" title="{{ $review->is_published ? 'Hide' : 'Publish' }}">
                                        <span class="material-symbols-outlined">{{ $review->is_published ? 'visibility_off' : 'visibility' }}</span>
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_verified" value="{{ $review->is_verified ? 0 : 1 }}">
                                    <button type="submit" class="p-2 {{ $review->is_verified ? 'text-blue-600' : 'text-slate-400 hover:text-blue-600' }} transition-colors" title="Toggle Verified Status">
                                        <span class="material-symbols-outlined">{{ $review->is_verified ? 'verified' : 'verified_user' }}</span>
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn p-2 text-slate-400 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-slate-300">rate_review</span>
                                <p class="text-slate-500 font-medium">No reviews found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-800/50">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .fill-1 { font-variation-settings: 'FILL' 1; }
</style>
@endsection
