@extends('layouts.admin')

@section('title', 'Marketing Dashboard')

@section('content')
<div class="max-w-[1200px] mx-auto p-4 md:p-6 space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Marketing</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Manage campaigns, automated emails, and promotions.</p>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- Left Column: Email Blast & Banner Manager -->
        <div class="space-y-6">
            <!-- Email Blast Card -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-2 rounded-lg text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Email Blast</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Create and send newsletters.</p>
                    </div>
                </div>

                <form action="{{ route('admin.marketing.email-blast') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Subject Line</label>
                        <input type="text" name="subject" placeholder="e.g., Summer Sale is Here! ☀️" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-slate-50 dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Target Audience</label>
                        <select name="audience" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-slate-50 dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">Semua Pelanggan (All Customers)</option>
                            <option value="vip">Pelanggan VIP (> 5 Pesanan)</option>
                            <option value="new">Pelanggan Baru (30 Hari Terakhir)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Message Content</label>
                        <textarea name="content" rows="4" placeholder="Write your awesome newsletter content here..." class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-slate-50 dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex justify-center items-center gap-2 shadow-lg shadow-blue-600/20">
                            <span class="material-symbols-outlined text-[20px]">send</span>
                            Send Campaign
                        </button>
                    </div>
                </form>
            </div>

            <!-- Banner Manager (Direct Link for now as implemented in Settings) -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-2 rounded-lg text-purple-600 dark:text-purple-400">
                            <span class="material-symbols-outlined">image</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Homepage Banners</h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Manage hero sliders.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-gray-800/50 rounded-lg p-4 text-center border border-dashed border-slate-300 dark:border-gray-700">
                     <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">To verify banner settings and upload new images, please visit the Home Page Settings.</p>
                     <a href="{{ route('admin.settings.index') }}?tab=homepage" class="text-blue-600 hover:underline text-sm font-medium">Go to Banner Settings</a>
                </div>
            </div>
        </div>

        <!-- Right Column: Abandoned Cart -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm h-fit">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-50 dark:bg-orange-900/20 p-2 rounded-lg text-orange-600 dark:text-orange-400">
                        <span class="material-symbols-outlined">shopping_cart_checkout</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Abandoned Cart Recovery</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">High potential customers to follow up.</p>
                    </div>
                </div>
                <button class="text-sm text-blue-600 font-medium hover:underline">View All</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-gray-800">
                            <th class="py-3 px-2 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Customer</th>
                            <th class="py-3 px-2 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total</th>
                            <th class="py-3 px-2 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                        @forelse($abandonedCarts as $cart)
                        @php
                            $total = $cart->items->sum(function($item) {
                                return $item->quantity * ($item->product->price ?? 0);
                            });
                            $customerName = $cart->user->name ?? 'Guest';
                            $cartStatus = $cart->updated_at->diffInHours(now()) > 24 ? 'sent' : 'pending'; // Dummy status logic
                        @endphp
                        <tr class="group hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-4 px-2">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-slate-600 dark:text-slate-300">
                                        {{ substr($customerName, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900 dark:text-white text-sm">{{ $customerName }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $cart->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2 font-semibold text-slate-900 dark:text-white text-sm">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <td class="py-4 px-2 text-right">
                                @if($cartStatus === 'sent')
                                    <span class="inline-flex items-center gap-1 text-green-600 text-xs font-medium bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                        Sent
                                    </span>
                                @else
                                    <button class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors text-xs font-medium">
                                        <span class="material-symbols-outlined text-[14px]">notifications_active</span>
                                        Ingatkan
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-slate-500 text-sm">Belum ada keranjang tertinggal.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
