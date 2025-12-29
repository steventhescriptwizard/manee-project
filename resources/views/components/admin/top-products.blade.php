<div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col h-full">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Top Selling Products</h3>
        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
    </div>

    <div class="flex flex-col gap-4 overflow-y-auto pr-2">
        @foreach($topProducts as $item)
        <div class="flex items-center gap-4 group cursor-pointer">
            <div 
                class="bg-center bg-no-repeat bg-cover rounded-lg h-12 w-12 border border-slate-100 dark:border-gray-800"
                style="background-image: url('{{ $item->product->image_main ? Storage::url($item->product->image_main) : 'https://via.placeholder.com/100' }}')"
            ></div>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-1">{{ $item->product->product_name }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->total_sales }} sales</p>
            </div>
            <span class="text-sm font-bold text-slate-900 dark:text-white">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>
</div>
