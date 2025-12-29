<div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 dark:border-gray-800 flex items-center justify-between">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Orders</h3>
        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View All</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                @foreach($recentOrders as $order)
                <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-slate-700 dark:text-slate-200">#{{ $order->order_number }}</span>
                            <div class="flex items-center gap-2">
                                <div class="size-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                </div>
                                <span class="text-slate-600 dark:text-slate-400">{{ $order->user->name }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                        @if($order->items->count() > 1)
                            {{ $order->items->first()->product->product_name }} + {{ $order->items->count() - 1 }} others
                        @else
                            {{ $order->items->first()->product->product_name ?? 'N/A' }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusClass = match(strtolower($order->status)) {
                                'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                'pending' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                'processing' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'shipped' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
