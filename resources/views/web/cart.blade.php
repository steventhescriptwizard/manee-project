@extends('layouts.web')

@section('title', 'Shopping Cart - Maneé')

@section('content')
<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-10 py-8 md:py-12 mt-20">
    <!-- Page Heading -->
    <div class="mb-8 md:mb-12">
        <h2 class="font-serif text-4xl md:text-5xl font-bold text-textMain mb-2">Shopping Cart</h2>
        <p class="text-gray-500 text-base font-light" id="cart-item-count">
            @if(count($cart) > 0)
                You have {{ count($cart) }} {{ Str::plural('item', count($cart)) }} in your cart.
            @else
                Your cart is currently empty.
            @endif
        </p>
    </div>

    @if(count($cart) > 0)
    <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 items-start" id="cart-content">
        <!-- Cart Items -->
        <div class="w-full lg:flex-1">
            <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 pb-3 mb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                <div class="col-span-6">Product</div>
                <div class="col-span-2 text-center">Price</div>
                <div class="col-span-2 text-center">Quantity</div>
                <div class="col-span-2 text-right">Total</div>
            </div>

            @foreach($cart as $key => $item)
            <!-- Item -->
            <div class="group relative flex flex-col md:grid md:grid-cols-12 gap-4 py-6 border-b border-gray-100 items-center cart-item" data-id="{{ $key }}">
                <div class="col-span-6 flex gap-4 w-full">
                    <div class="relative w-24 h-32 md:w-28 md:h-36 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
                        <img alt="{{ $item['name'] }}" class="w-full h-full object-cover" src="{{ $item['image'] ? Storage::url($item['image']) : 'https://via.placeholder.com/200x300' }}"/>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="font-serif text-xl font-semibold text-textMain mb-1">{{ $item['name'] }}</h3>
                        @if($item['color']) <p class="text-xs text-gray-500 mb-1">Color: {{ $item['color'] }}</p> @endif
                        @if($item['size']) <p class="text-xs text-gray-500">Size: {{ $item['size'] }}</p> @endif
                        <div class="md:hidden mt-2 text-sm font-bold text-textMain">Rp {{ number_format($item['final_price'], 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="hidden md:block col-span-2 text-center text-gray-600">Rp {{ number_format($item['final_price'], 0, ',', '.') }}</div>
                <div class="col-span-12 md:col-span-2 flex justify-start md:justify-center mt-2 md:mt-0">
                    <div class="flex items-center border border-gray-200 rounded-lg h-9 bg-white">
                        <button onclick="updateQuantity('{{ $key }}', -1)" class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-textMain">
                            <span class="material-symbols-outlined text-[16px]">remove</span>
                        </button>
                        <input class="w-10 h-full text-center border-none text-sm font-medium p-0 quantity-input" readonly type="text" value="{{ $item['quantity'] }}"/>
                        <button onclick="updateQuantity('{{ $key }}', 1)" class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-textMain">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                        </button>
                    </div>
                </div>
                <div class="hidden md:block col-span-2 text-right font-bold text-textMain item-total">Rp {{ number_format($item['final_price'] * $item['quantity'], 0, ',', '.') }}</div>
                <button onclick="removeItem('{{ $key }}')" class="absolute top-6 right-0 text-gray-300 hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
            </div>
            @endforeach

            <div class="mt-8 flex justify-between items-center">
                <a class="inline-flex items-center gap-2 text-sm font-medium text-textMain hover:text-brandBlue transition-colors group" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Continue Shopping
                </a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1 uppercase tracking-widest font-bold">
                        <span class="material-symbols-outlined text-[16px]">delete_sweep</span>
                        Clear Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- Summary -->
        <div class="w-full lg:w-[380px] xl:w-[420px] flex-shrink-0">
            <div class="lg:sticky lg:top-28 bg-[#f8f9fc] rounded-xl p-6 md:p-8 border border-gray-100">
                <h3 class="font-serif text-2xl font-bold text-textMain mb-6">Order Summary</h3>
                <div class="space-y-4 mb-6 border-b border-gray-200 pb-6">
                    <div class="flex justify-between items-center text-gray-500">
                        <span class="text-sm">Subtotal</span>
                        <span class="font-medium text-textMain" id="cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
                        <span class="font-serif text-2xl font-bold text-textMain" id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
    @else
    <div class="text-center py-24 bg-[#f8f9fc] rounded-3xl border border-dashed border-gray-200">
        <div class="inline-flex items-center justify-center h-24 w-24 bg-white rounded-full shadow-sm mb-6">
            <span class="material-symbols-outlined text-4xl text-gray-300">shopping_bag</span>
        </div>
        <h3 class="text-2xl font-serif font-bold text-textMain mb-2">Your cart is empty</h3>
        <p class="text-gray-500 mb-10 max-w-md mx-auto font-light">Looks like you haven't added anything to your cart yet. Explore our latest collection and find something you love.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-brandBlue hover:bg-brandBlue/90 text-white px-8 py-4 rounded-lg font-bold text-sm tracking-widest uppercase transition-all shadow-md">
            Start Shopping
            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
        </a>
    </div>
    @endif
</main>

<script>
async function updateQuantity(key, delta) {
    const itemRow = document.querySelector(`.cart-item[data-id="${key}"]`);
    const input = itemRow.querySelector('.quantity-input');
    let newQty = parseInt(input.value) + delta;
    
    if (newQty < 1) return;

    try {
        const response = await fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: key, quantity: newQty })
        });

        if (response.ok) {
            location.reload(); // Simple reload for now, can be optimized later
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
    }
}

async function removeItem(key) {
    if (!confirm('Remove this item from cart?')) return;

    try {
        const response = await fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: key })
        });

        if (response.ok) {
            location.reload();
        }
    } catch (error) {
        console.error('Error removing item:', error);
    }
}
</script>
</main>
@endsection
