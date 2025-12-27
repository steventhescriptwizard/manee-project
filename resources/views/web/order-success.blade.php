@extends('layouts.web')

@section('title', 'Order Confirmed - Maneé')

@section('content')
<main class="flex-grow container mx-auto px-6 py-12 lg:py-20 mt-20">
    <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 shadow-sm border border-gray-50 rounded-sm text-center">
        <div class="w-16 h-16 bg-brandLightBlue/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-3xl text-textMain">check</span>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-serif italic font-medium text-textMain mb-4 leading-tight">
            Order Placed Successfully!
        </h1>
        <p class="text-gray-500 font-light text-lg max-w-lg mx-auto mb-12">
            Thank you for shopping at Maneé. A confirmation email with your order details has been sent to your inbox.
        </p>

        <div class="bg-brandCream p-8 rounded-lg mb-12 flex flex-col md:flex-row justify-between items-center gap-8 border-l-4 border-brandBlue/20">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-12 text-left w-full">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1 font-bold">Order Number</p>
                    <p class="font-medium text-lg text-textMain">#MN-8823</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1 font-bold">Date</p>
                    <p class="font-medium text-lg text-textMain">{{ now()->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1 font-bold">Total Amout</p>
                    <p class="font-medium text-lg text-brandRed">Rp 899.000</p>
                </div>
            </div>
            <button class="text-xs border-b-2 border-textMain font-bold uppercase tracking-widest hover:text-gray-500 transition-colors whitespace-nowrap">
                Print Invoice
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <a href="{{ route('home') }}" class="block w-full bg-textMain text-white py-4 px-6 text-xs font-bold tracking-widest uppercase hover:bg-gray-800 transition-colors rounded-lg shadow-md">
                Back to Home
            </a>
            <button class="block w-full border-2 border-textMain text-textMain py-4 px-6 text-xs font-bold tracking-widest uppercase hover:bg-gray-50 transition-colors rounded-lg">
                Track My Order
            </button>
        </div>
    </div>
</main>
@endsection
