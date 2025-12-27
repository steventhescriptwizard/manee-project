@extends('layouts.web')

@section('title', 'Checkout - Maneé')

@section('content')
<main class="mx-auto max-w-[1280px] px-6 py-10 lg:px-10 mt-20">
    <div class="mb-8 flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a class="hover:text-gray-900" href="{{ route('home') }}">Home</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a class="hover:text-gray-900" href="{{ route('cart') }}">Cart</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="font-medium text-textMain">Checkout</span>
    </div>

    <h1 class="mb-10 font-serif text-3xl font-bold text-textMain lg:text-4xl">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-16">
        <div class="lg:col-span-7 space-y-10">
            <!-- Step 1: Shipping -->
            <section>
                <h2 class="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue text-white text-sm font-bold">1</span>
                    Shipping Information
                </h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-widest" for="first-name">First Name</label>
                            <input class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm focus:ring-brandBlue focus:border-brandBlue" id="first-name" placeholder="First name" type="text"/>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-widest" for="last-name">Last Name</label>
                            <input class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm focus:ring-brandBlue focus:border-brandBlue" id="last-name" placeholder="Last name" type="text"/>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-widest" for="email">Email Address</label>
                        <input class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm focus:ring-brandBlue focus:border-brandBlue" id="email" placeholder="email@example.com" type="email"/>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-widest" for="address">Full Address</label>
                        <textarea class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm focus:ring-brandBlue focus:border-brandBlue" id="address" placeholder="Street, City, Postal Code" rows="3"></textarea>
                    </div>
                </form>
            </section>

            <!-- Step 2: Payment -->
            <section class="border-t border-gray-100 pt-10">
                <h2 class="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue text-white text-sm font-bold">2</span>
                    Payment Method
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    @foreach(['Credit Card', 'Bank Transfer', 'E-Wallet'] as $method)
                    <button class="flex flex-col items-center justify-center rounded-lg border-2 border-gray-100 p-4 transition-all hover:border-brandBlue {{ $loop->first ? 'border-brandBlue bg-brandBlue/5' : '' }}">
                        <span class="material-symbols-outlined mb-2 text-2xl">{{ $loop->first ? 'credit_card' : ($loop->remaining == 1 ? 'account_balance' : 'wallet') }}</span>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ $method }}</span>
                    </button>
                    @endforeach
                </div>
                <div class="rounded-lg bg-gray-50 p-6 space-y-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Card Number</label>
                        <input class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm" placeholder="0000 0000 0000 0000" type="text"/>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Expiry Date</label>
                            <input class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm" placeholder="MM/YY" type="text"/>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">CVV</label>
                            <input class="w-full rounded-md border-gray-200 bg-white px-4 py-3 text-sm" placeholder="123" type="text"/>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Summary -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 rounded-xl border border-gray-100 bg-white p-6 shadow-sm lg:p-8">
                <h2 class="mb-6 font-serif text-2xl font-semibold text-textMain">Order Summary</h2>
                <div class="space-y-6 mb-6">
                    <div class="flex gap-4">
                        <div class="h-20 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                            <img alt="Item" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhlZwnI19XMPjD5L70T2DeYMnlyT_5F_BhII1IoU4Bwu4zUex_luuaD7r2KJzRy5SAnf44NIsWrVcCP2Batu_WeHywM8g93bXeLs6h8pcb5YBPwCeeNdfwWrVBSnmlenuqrt2zDSss7s-MfIdK1A5mYPOpF1aCP4PfDbdnPRtATBvKPLv4rnrA672R-JFST_XR8gf2n7xC0bV5WdLQBJrZU-M1bhFPUolEssRuU0GKpoXIWXYzmKXIXJM6-LE-QubX0xMmYdlTOmE"/>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-sm font-bold text-textMain">Classic Linen Shirt</h3>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase">Sage Green / M</p>
                                </div>
                                <span class="text-sm font-bold">Rp 349.000</span>
                            </div>
                            <span class="text-[10px] text-gray-400">Qty: 1</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 py-6 space-y-3">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span>Rp 349.000</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Shipping</span>
                        <span class="text-green-600 font-bold uppercase text-[10px]">Free</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-4 font-serif text-xl font-bold text-textMain">
                        <span>Total</span>
                        <span>Rp 349.000</span>
                    </div>
                </div>

                <a href="{{ route('order.success') }}" class="mt-8 inline-block w-full rounded-lg bg-brandBlue py-4 text-center font-sans text-xs font-bold tracking-widest text-white uppercase transition-all hover:bg-brandBlue/90 active:scale-95 shadow-md">
                    Place Order
                </a>
                <div class="mt-4 flex items-center justify-center gap-2 text-[10px] text-gray-400 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[14px]">lock</span>
                    Secure Checkout
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
