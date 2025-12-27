@extends('layouts.web')

@section('title', 'Shopping Cart - Maneé')

@section('content')
<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-10 py-8 md:py-12 mt-20">
    <!-- Page Heading -->
    <div class="mb-8 md:mb-12">
        <h2 class="font-serif text-4xl md:text-5xl font-bold text-textMain mb-2">Shopping Cart</h2>
        <p class="text-gray-500 text-base font-light">You have 2 items in your cart.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 items-start">
        <!-- Cart Items -->
        <div class="w-full lg:flex-1">
            <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 pb-3 mb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                <div class="col-span-6">Product</div>
                <div class="col-span-2 text-center">Price</div>
                <div class="col-span-2 text-center">Quantity</div>
                <div class="col-span-2 text-right">Total</div>
            </div>

            <!-- Item 1 -->
            <div class="group relative flex flex-col md:grid md:grid-cols-12 gap-4 py-6 border-b border-gray-100 items-center">
                <div class="col-span-6 flex gap-4 w-full">
                    <div class="relative w-24 h-32 md:w-28 md:h-36 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                        <img alt="Product" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9WD5L-06GMlWbzMFwmawuRP5VcqNUcV7orB9WKOwSJZ9ZRPle98xt47NB3jt5nmpIVK-DH5m7a9Q4XozkBKdTQ-PGWkwLuAeLFgVwJEl6wIJ90Aky8yIoSuGbieQAUMVFc9tsdSzByC_DOIfpG3zTxZ8hdD5nfE2t08Ht3rkBajYIIVhUEumCGGd81FOg1KD4JTG9GLT9-_-91TwyxrrzRFHbugywEi3__xjE6xzpbTKUyEI7Hi03kuB4tzlo_OtykzfOVvjsZ_E"/>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="font-serif text-xl font-semibold text-textMain mb-1">Maneé Classic Linen Shirt</h3>
                        <p class="text-xs text-gray-500 mb-1">Color: Natural White</p>
                        <p class="text-xs text-gray-500">Size: M</p>
                        <div class="md:hidden mt-2 text-sm font-bold text-textMain">Rp 299.000</div>
                    </div>
                </div>
                <div class="hidden md:block col-span-2 text-center text-gray-600">Rp 299.000</div>
                <div class="col-span-12 md:col-span-2 flex justify-start md:justify-center mt-2 md:mt-0">
                    <div class="flex items-center border border-gray-200 rounded-lg h-9 bg-white">
                        <button class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-textMain"><span class="material-symbols-outlined text-[16px]">remove</span></button>
                        <input class="w-10 h-full text-center border-none text-sm font-medium p-0" readonly type="text" value="1"/>
                        <button class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-textMain"><span class="material-symbols-outlined text-[16px]">add</span></button>
                    </div>
                </div>
                <div class="hidden md:block col-span-2 text-right font-bold text-textMain">Rp 299.000</div>
                <button class="absolute top-6 right-0 text-gray-300 hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[20px]">delete</span></button>
            </div>

            <!-- Item 2 -->
            <div class="group relative flex flex-col md:grid md:grid-cols-12 gap-4 py-6 border-b border-gray-100 items-center">
                <div class="col-span-6 flex gap-4 w-full">
                    <div class="relative w-24 h-32 md:w-28 md:h-36 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                        <img alt="Product" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBdqwjIjQuWcCEX2ULDtBXsCeWbrBUmgkpHwz4vx3rSchzDR05gWN-QjMSdd1FeSE2s7mRFDemBCBeWcQMzTKUn0m-qff4s0dgMJD4KoJCmLaLGPWBiXLHrujIoao8B4E2sI0R8HAtjZSVdwIsm7sQDYGNWZeaOxBYafeLfiyVq2f2RzZWNBvJeM04hO6sazY1EB2zjSIEX3jQUYaQDnnBsMwfbDcChJWwSxy2vJFaXzQU-rDn8wegiN_MCfRDjR1AJfk509uWzrY"/>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="font-serif text-xl font-semibold text-textMain mb-1">Silk Midi Skirt</h3>
                        <p class="text-xs text-gray-500 mb-1">Color: Champagne</p>
                        <p class="text-xs text-gray-500">Size: S</p>
                        <div class="md:hidden mt-2 text-sm font-bold text-textMain">Rp 349.000</div>
                    </div>
                </div>
                <div class="hidden md:block col-span-2 text-center text-gray-600">Rp 349.000</div>
                <div class="col-span-12 md:col-span-2 flex justify-start md:justify-center mt-2 md:mt-0">
                    <div class="flex items-center border border-gray-200 rounded-lg h-9 bg-white">
                        <button class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-textMain"><span class="material-symbols-outlined text-[16px]">remove</span></button>
                        <input class="w-10 h-full text-center border-none text-sm font-medium p-0" readonly type="text" value="1"/>
                        <button class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-textMain"><span class="material-symbols-outlined text-[16px]">add</span></button>
                    </div>
                </div>
                <div class="hidden md:block col-span-2 text-right font-bold text-textMain">Rp 349.000</div>
                <button class="absolute top-6 right-0 text-gray-300 hover:text-red-500 transition-colors"><span class="material-symbols-outlined text-[20px]">delete</span></button>
            </div>

            <div class="mt-8">
                <a class="inline-flex items-center gap-2 text-sm font-medium text-textMain hover:text-brandBlue transition-colors group" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Continue Shopping
                </a>
            </div>
        </div>

        <!-- Summary -->
        <div class="w-full lg:w-[380px] xl:w-[420px] flex-shrink-0">
            <div class="lg:sticky lg:top-28 bg-[#f8f9fc] rounded-xl p-6 md:p-8 border border-gray-100">
                <h3 class="font-serif text-2xl font-bold text-textMain mb-6">Order Summary</h3>
                <div class="space-y-4 mb-6 border-b border-gray-200 pb-6">
                    <div class="flex justify-between items-center text-gray-500">
                        <span class="text-sm">Subtotal</span>
                        <span class="font-medium text-textMain">Rp 648.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-500">
                        <span class="text-sm">Shipping</span>
                        <span class="text-xs italic">Calculated at checkout</span>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-widest">Promo Code</label>
                    <div class="flex gap-2">
                        <input class="flex-1 rounded-lg border-gray-200 bg-white text-sm focus:ring-brandBlue focus:border-brandBlue" placeholder="Enter code" type="text"/>
                        <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Apply</button>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-8">
                    <span class="font-serif text-xl font-bold text-textMain">Total</span>
                    <div class="flex flex-col items-end">
                        <span class="font-serif text-2xl font-bold text-textMain">Rp 648.000</span>
                        <span class="text-[10px] text-gray-400">Including VAT</span>
                    </div>
                </div>
                <a href="{{ route('checkout') }}" class="w-full bg-brandBlue hover:bg-brandBlue/90 text-white rounded-lg py-4 px-4 font-bold text-sm tracking-widest uppercase transition-all shadow-md flex items-center justify-center gap-2 group">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                    Checkout
                </a>
                <div class="mt-6 grid grid-cols-3 gap-2 text-center text-[10px] text-gray-400">
                    <div class="flex flex-col items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">verified_user</span>
                        <span>Secure Payment</span>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                        <span>Fast Delivery</span>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">sync_alt</span>
                        <span>Easy Returns</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
