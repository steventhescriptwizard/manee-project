@extends('layouts.web')

@section('title', 'Customer Reviews - Maneé')

@section('content')
<div class="bg-white min-h-screen pt-24 pb-20">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-10">
        <!-- Breadcrumbs -->
        <nav class="mb-8 flex items-center gap-2 text-sm text-gray-500">
            <a class="hover:text-gray-900" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="font-medium text-textMain">Customer Reviews</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            <!-- Sidebar Stats -->
            <aside class="lg:col-span-4 space-y-8">
                <div class="flex flex-col gap-3">
                    <h1 class="text-textMain text-4xl lg:text-5xl font-serif font-bold leading-tight tracking-tight">
                        Customer <br>Reviews
                    </h1>
                    <p class="text-gray-500 text-lg font-light italic">
                        What modern Indonesian women say about Maneé collections.
                    </p>
                </div>

                <!-- Rating Summary Card -->
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                    <div class="flex items-baseline gap-4 mb-8">
                        <span class="text-7xl font-serif font-bold text-textMain tracking-tighter">{{ $averageRating }}</span>
                        <div class="flex flex-col">
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <span class="material-symbols-outlined fill-1">star</span>
                                    @elseif($i - $averageRating < 1)
                                        <span class="material-symbols-outlined fill-1">star_half</span>
                                    @else
                                        <span class="material-symbols-outlined">star</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500 mt-1 font-medium italic">Based on {{ $totalCount }} reviews</span>
                        </div>
                    </div>

                    <!-- Progress Bars -->
                    <div class="space-y-4">
                        @foreach($stats as $stat)
                        <div class="grid grid-cols-[24px_1fr_45px] items-center gap-4">
                            <span class="text-sm font-bold text-textMain">{{ $stat['star'] }}</span>
                            <div class="h-2.5 w-full bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full {{ $stat['color'] }} rounded-full" style="width: {{ $stat['percentage'] }}%"></div>
                            </div>
                            <span class="text-xs text-gray-400 text-right font-medium">{{ $stat['percentage'] }}%</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-6 font-light italic">
                            Already purchased our products? Share your experience with us.
                        </p>
                        <button onclick="document.getElementById('review-form-modal').classList.remove('hidden')" class="w-full flex items-center justify-center gap-2 bg-brandBlue text-white hover:bg-black transition-all h-14 rounded-xl font-bold shadow-lg shadow-brandBlue/20 transform hover:-translate-y-0.5 uppercase tracking-widest text-xs">
                            <span class="material-symbols-outlined text-[20px]">edit_note</span>
                            <span>Write a Review</span>
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="lg:col-span-8">
                <!-- Filter Bar -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10 pb-6 border-b border-gray-100">
                    <div class="flex flex-wrap gap-2">
                        @php $activeFilter = request('filter', 'all'); @endphp
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}" 
                           class="px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ $activeFilter === 'all' ? 'bg-brandBlue text-white shadow-md' : 'bg-white border border-gray-200 text-gray-500 hover:border-gray-300' }}">
                            All Reviews
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'with_photo']) }}" 
                           class="px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ $activeFilter === 'with_photo' ? 'bg-brandBlue text-white shadow-md' : 'bg-white border border-gray-200 text-gray-500 hover:border-gray-300' }}">
                            With Photos
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['filter' => 'verified']) }}" 
                           class="px-5 py-2.5 rounded-full text-sm font-bold transition-all {{ $activeFilter === 'verified' ? 'bg-brandBlue text-white shadow-md' : 'bg-white border border-gray-200 text-gray-500 hover:border-gray-300' }}">
                            Verified Purchase
                        </a>
                    </div>

                    <div class="relative min-w-[180px]">
                        @php $activeSort = request('sort', 'newest'); @endphp
                        <form action="{{ url()->current() }}" method="GET" id="sort-form">
                            @foreach(request()->except('sort') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" onchange="document.getElementById('sort-form').submit()" 
                                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border-gray-200 text-sm font-bold text-textMain focus:ring-brandBlue focus:border-brandBlue appearance-none bg-white">
                                <option value="newest" {{ $activeSort === 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="highest" {{ $activeSort === 'highest' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="lowest" {{ $activeSort === 'lowest' ? 'selected' : '' }}>Lowest Rated</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="space-y-8">
                    @forelse($reviews as $review)
                    <article class="flex flex-col md:flex-row gap-8 p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-1 space-y-4">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-4">
                                    <div class="size-12 rounded-full bg-brandCream border border-gray-100 flex items-center justify-center font-bold text-brandBlue text-lg">
                                        {{ str($review->user->name)->substr(0, 1)->upper() }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <h4 class="font-bold text-textMain text-base">{{ $review->user->name }}</h4>
                                            @if($review->is_verified)
                                            <span class="flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-green-700 bg-green-50 px-2.5 py-1 rounded-full border border-green-100">
                                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                                Verified
                                            </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex text-amber-400 text-sm">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="material-symbols-outlined text-[18px] {{ $i <= $review->rating ? 'fill-1' : '' }}">star</span>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-400 font-medium italic">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($review->title)
                            <h3 class="font-serif font-bold text-xl text-textMain">{{ $review->title }}</h3>
                            @endif
                            
                            <p class="text-gray-500 leading-relaxed text-sm font-light italic">
                                "{{ $review->content }}"
                            </p>

                            @if($review->images->count() > 0)
                            <div class="flex flex-wrap gap-3 pt-2">
                                @foreach($review->images as $img)
                                <div class="h-24 w-24 rounded-xl bg-gray-50 overflow-hidden cursor-pointer hover:opacity-90 transition-opacity border border-gray-100 shadow-sm">
                                    <img class="h-full w-full object-cover" src="{{ Storage::url($img->image_path) }}" alt="Review photo">
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Product Thumbnail -->
                        <div class="md:w-40 flex flex-row md:flex-col gap-4 md:border-l border-gray-100 md:pl-8">
                            <a href="{{ route('products.show', $review->product->id) }}" class="h-28 w-28 md:w-full rounded-xl bg-gray-50 overflow-hidden border border-gray-100 flex-shrink-0 group">
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $review->product->image_main ? Storage::url($review->product->image_main) : 'https://via.placeholder.com/300x400' }}" alt="{{ $review->product->product_name }}">
                            </a>
                            <div class="flex flex-col justify-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Product</p>
                                <a href="{{ route('products.show', $review->product->id) }}" class="text-sm font-bold text-textMain hover:text-brandBlue transition-colors line-clamp-2 uppercase">
                                    {{ $review->product->product_name }}
                                </a>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">rate_review</span>
                        <p class="text-gray-500 font-medium font-serif italic text-xl">No reviews found for this selection.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-16">
                    {{ $reviews->links() }}
                </div>
            </main>
        </div>
    </div>
</div>

<!-- Simple Write Review Modal (Placeholder/Minimal) -->
<div id="review-form-modal" class="hidden fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('review-form-modal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-middle bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-8 pt-8 pb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-serif font-bold text-textMain">Write a Review</h3>
                        <button type="button" onclick="document.getElementById('review-form-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-900 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Select Product</label>
                            <select name="product_id" required class="w-full rounded-xl border-gray-200 text-sm focus:ring-brandBlue focus:border-brandBlue font-bold">
                                @php $products = \App\Models\Product::orderBy('product_name')->get(); @endphp
                                @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Rating</label>
                            <div class="flex gap-2" x-data="{ rating: 5 }">
                                <input type="hidden" name="rating" :value="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" @click="rating = {{ $i }}" class="text-gray-300 hover:text-amber-400" :class="rating >= {{ $i }} ? 'text-amber-400' : ''">
                                    <span class="material-symbols-outlined text-3xl fill-1" x-show="rating >= {{ $i }}">star</span>
                                    <span class="material-symbols-outlined text-3xl" x-show="rating < {{ $i }}">star</span>
                                </button>
                                @endfor
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Title (Optional)</label>
                            <input type="text" name="title" placeholder="Summary of your experience" class="w-full rounded-xl border-gray-200 text-sm focus:ring-brandBlue focus:border-brandBlue">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Your Review</label>
                            <textarea name="content" rows="4" required placeholder="Tell us what you liked or disliked..." class="w-full rounded-xl border-gray-200 text-sm focus:ring-brandBlue focus:border-brandBlue"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Add Photos</label>
                            <input type="file" name="images[]" multiple class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        </div>
                    </div>
                </div>
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-right">
                    <button type="button" onclick="document.getElementById('review-form-modal').classList.add('hidden')" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-900 mr-4 uppercase tracking-widest">Cancel</button>
                    <button type="submit" class="bg-brandBlue text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-black transition-all shadow-lg shadow-brandBlue/20 uppercase tracking-widest">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .fill-1 { font-variation-settings: 'FILL' 1; }
</style>
@endpush
