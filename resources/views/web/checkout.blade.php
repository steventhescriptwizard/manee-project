@extends('layouts.web')

@section('title', 'Checkout - Maneé')

@section('content')
<main class="mx-auto max-w-[1280px] px-6 py-10 lg:px-10 mt-20" x-data="{ 
    shippingAddressId: '{{ $addresses->where('is_primary', true)->first()->id ?? ($addresses->first()->id ?? '') }}',
    paymentMethod: 'Credit Card',
    shippingMethod: 'JNE Regular'
}">
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
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <input type="hidden" name="shipping_address_id" :value="shippingAddressId">
                <input type="hidden" name="payment_method" :value="paymentMethod">
                <input type="hidden" name="shipping_method" :value="shippingMethod">

                <!-- Step 1: Shipping -->
                <section>
                    <h2 class="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue text-white text-sm font-bold">1</span>
                        Alamat Pengiriman
                    </h2>
                    
                    <div class="space-y-4">
                        @forelse($addresses as $address)
                            <div @click="shippingAddressId = '{{ $address->id }}'" 
                                 :class="shippingAddressId == '{{ $address->id }}' ? 'border-brandBlue bg-brandBlue/5' : 'border-gray-100 bg-white'"
                                 class="relative p-6 rounded-2xl border-2 cursor-pointer transition-all hover:border-brandBlue/50 group">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#111318]">{{ $address->label }}</span>
                                        @if($address->is_primary)
                                            <span class="text-[8px] bg-brandBlue text-white px-2 py-0.5 rounded-full uppercase font-bold">Utama</span>
                                        @endif
                                    </div>
                                    <div :class="shippingAddressId == '{{ $address->id }}' ? 'text-brandBlue' : 'text-gray-200'" class="transition-colors">
                                        <span class="material-symbols-outlined">check_circle</span>
                                    </div>
                                </div>
                                <p class="font-bold text-textMain italic text-sm mb-1">{{ $address->recipient_name }}</p>
                                <p class="text-xs text-gray-500 font-light italic mb-2">{{ $address->phone_number }}</p>
                                <p class="text-xs text-gray-400 leading-relaxed italic">
                                    {{ $address->address_line }}, {{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}
                                </p>
                            </div>
                        @empty
                            <div class="p-8 border-2 border-dashed border-gray-200 rounded-2xl text-center">
                                <p class="text-gray-400 text-sm italic mb-4">Anda belum memiliki alamat pengiriman yang tersimpan.</p>
                                <a href="{{ route('customer.address') }}" class="inline-block px-6 py-3 bg-black text-white text-[10px] font-bold uppercase tracking-widest rounded-xl hover:bg-brandBlue transition-all">
                                    Tambah Alamat Baru
                                </a>
                            </div>
                        @endforelse
                    </div>

                    @error('shipping_address_id')
                        <p class="mt-2 text-xs text-red-500 font-bold italic">{{ $message }}</p>
                    @enderror
                </section>

                <!-- Step 2: Shipping Method -->
                <section class="border-t border-gray-100 pt-10 mt-10">
                    <h2 class="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue text-white text-sm font-bold">2</span>
                        Metode Pengiriman
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(['JNE Regular', 'J&T Express', 'SiCepat Reg'] as $method)
                            <button type="button" @click="shippingMethod = '{{ $method }}'"
                                    :class="shippingMethod == '{{ $method }}' ? 'border-brandBlue bg-brandBlue/5' : 'border-gray-100 bg-white'"
                                    class="flex items-center justify-between p-4 rounded-xl border-2 transition-all hover:border-brandBlue/50">
                                <span class="text-xs font-bold uppercase tracking-widest text-[#111318]">{{ $method }}</span>
                                <span class="text-xs text-gray-400 italic">Rp 15.000</span>
                            </button>
                        @endforeach
                    </div>
                </section>

                <!-- Step 3: Payment -->
                <section class="border-t border-gray-100 pt-10 mt-10">
                    <h2 class="mb-6 flex items-center gap-3 font-serif text-2xl font-semibold text-textMain">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brandBlue text-white text-sm font-bold">3</span>
                        Metode Pembayaran
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        @foreach(['Credit Card', 'Bank Transfer', 'E-Wallet'] as $method)
                        <button type="button" @click="paymentMethod = '{{ $method }}'"
                                :class="paymentMethod == '{{ $method }}' ? 'border-brandBlue bg-brandBlue/5' : 'border-gray-100 bg-white'"
                                class="flex flex-col items-center justify-center rounded-lg border-2 p-4 transition-all hover:border-brandBlue/50">
                            <span class="material-symbols-outlined mb-2 text-2xl">{{ $method === 'Credit Card' ? 'credit_card' : ($method === 'Bank Transfer' ? 'account_balance' : 'wallet') }}</span>
                            <span class="text-[10px] font-bold uppercase tracking-widest">{{ $method }}</span>
                        </button>
                        @endforeach
                    </div>
                    
                    <div class="rounded-2xl bg-gray-50 p-6 space-y-4 border border-gray-100">
                        <div x-show="paymentMethod === 'Credit Card'" class="text-sm italic text-gray-500 font-light">
                            <p>Pembayaran kartu kredit Anda akan diproses secara aman melalui Midtrans.</p>
                        </div>
                        <div x-show="paymentMethod === 'Bank Transfer'" class="text-sm italic text-gray-500 font-light">
                            <p>Anda dapat memilih berbagai bank (VA) melalui popup pembayaran Midtrans.</p>
                        </div>
                        <div x-show="paymentMethod === 'E-Wallet'" class="text-sm italic text-gray-500 font-light">
                            <p>Tersedia metode pembayaran QRIS, GoPay, dan lainnya melalui Midtrans.</p>
                        </div>
                    </div>
                </section>

                <!-- Notes -->
                <section class="border-t border-gray-100 pt-10 mt-10">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Catatan Pesanan (Opsional)</label>
                    <textarea name="notes" class="w-full rounded-2xl border-gray-100 bg-white px-6 py-4 text-sm focus:border-brandBlue focus:ring-brandBlue transition-all italic font-serif" placeholder="Tuliskan catatan khusus untuk pesanan Anda..." rows="3"></textarea>
                </section>
            </form>
        </div>

        <!-- Summary -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 rounded-[2rem] border border-gray-100 bg-white p-6 shadow-xl lg:p-8 animate-fade-in">
                <h2 class="mb-8 font-serif text-2xl font-bold text-textMain italic">Ringkasan Pesanan</h2>
                
                <div class="space-y-6 mb-8 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($cart as $key => $item)
                    <div class="flex gap-4 group">
                        <div class="h-20 w-16 flex-shrink-0 overflow-hidden rounded-xl border border-gray-100 shadow-sm transition-transform group-hover:scale-105">
                            <img alt="{{ $item['name'] }}" class="h-full w-full object-cover" src="{{ $item['image'] ? Storage::url($item['image']) : 'https://via.placeholder.com/200x300' }}"/>
                        </div>
                        <div class="flex-1 flex flex-col justify-between py-1">
                            <div>
                                <h3 class="text-sm font-bold text-textMain line-clamp-1 italic font-serif">{{ $item['name'] }}</h3>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-widest">
                                    {{ $item['color'] ?? '' }} {{ isset($item['color']) && isset($item['size']) ? '/' : '' }} {{ $item['size'] ?? '' }}
                                </p>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-[10px] text-gray-400 italic">Qty: {{ $item['quantity'] }}</span>
                                <span class="text-sm font-bold text-brandBlue italic">Rp {{ number_format($item['final_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 py-6 space-y-4">
                    <div class="flex justify-between text-sm text-gray-500 italic">
                        <span class="font-light">Subtotal</span>
                        <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Discount Section -->
                    <div class="space-y-2">
                        <div class="flex gap-2">
                            <input type="text" id="discount_code" name="discount_code" placeholder="Enter Discount Code" class="w-full text-xs rounded-lg border-gray-200 bg-gray-50 focus:border-brandBlue focus:ring-brandBlue font-mono uppercase">
                            <button type="button" id="apply-discount" class="bg-gray-900 text-white text-[10px] font-bold uppercase tracking-widest px-3 rounded-lg hover:bg-brandBlue transition-colors">Apply</button>
                        </div>
                        <p id="discount-message" class="text-[10px] hidden"></p>
                    </div>

                    <div id="discount-row" class="flex justify-between text-sm text-gray-500 italic hidden">
                        <span class="font-light">Discount</span>
                        <span class="font-bold text-red-500">- Rp <span id="discount-amount">0</span></span>
                    </div>

                    <div id="tax-row" class="flex justify-between text-sm text-gray-500 italic hidden">
                        <span class="font-light">Tax (PPN)</span>
                        <span class="font-bold">Rp <span id="tax-amount">0</span></span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-500 italic">
                        <span class="font-light">Biaya Pengiriman</span>
                        <span class="font-bold text-green-600">Rp 15.000</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-6 font-serif text-2xl font-bold text-textMain italic">
                        <span>Total</span>
                        <span class="text-brandBlue">Rp <span id="final-total">{{ number_format($total + 15000, 0, ',', '.') }}</span></span>
                    </div>
                </div>

                <button 
                    type="button" 
                    id="place-order-button"
                    class="mt-8 w-full rounded-2xl bg-[#111318] py-5 text-center font-sans text-xs font-bold tracking-[0.2em] text-white uppercase transition-all hover:bg-brandBlue active:scale-[0.98] shadow-2xl shadow-black/10 flex items-center justify-center gap-3 disabled:bg-gray-400"
                >
                    <span id="button-text">Place Order</span>
                    <span id="button-spinner" class="material-symbols-outlined text-[18px] animate-spin hidden">sync</span>
                    <span id="button-icon" class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
                
                <div class="mt-6 flex items-center justify-center gap-2 text-[10px] text-gray-400 uppercase tracking-widest font-bold font-serif italic">
                    <span class="material-symbols-outlined text-[14px]">lock</span>
                    Pembayaran Aman & Terenkripsi
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('place-order-button').onclick = function(e) {
        e.preventDefault();
        
        const button = this;
        const text = document.getElementById('button-text');
        const spinner = document.getElementById('button-spinner');
        const icon = document.getElementById('button-icon');
        const form = document.getElementById('checkout-form');

        // Show loading state
        button.disabled = true;
        text.innerText = 'Processing...';
        spinner.classList.remove('hidden');
        icon.classList.add('hidden');

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = data.redirect_url;
                    },
                    onPending: function(result) {
                        window.location.href = data.redirect_url;
                    },
                    onError: function(result) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: 'Silakan coba lagi atau gunakan metode pembayaran lain.',
                            confirmButtonColor: '#111318',
                            customClass: {
                                popup: 'rounded-2xl font-sans',
                                title: 'font-serif italic font-bold text-lg',
                                confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest text-[10px]'
                            }
                        });
                        button.disabled = false;
                        text.innerText = 'Place Order';
                        spinner.classList.add('hidden');
                        icon.classList.remove('hidden');
                    },
                    onClose: function() {
                        // User closed the popup without finishing payment
                        window.location.href = data.redirect_url;
                    }
                });
            } else {
                let errorMessage = data.message || 'Terjadi kesalahan saat membuat pesanan.';
                if (data.errors) {
                    const firstErrorKey = Object.keys(data.errors)[0];
                    if (firstErrorKey) {
                        errorMessage = data.errors[firstErrorKey][0];
                    }
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: errorMessage,
                    confirmButtonColor: '#111318',
                    customClass: {
                        popup: 'rounded-2xl font-sans',
                        title: 'font-serif italic font-bold text-lg',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest text-[10px]'
                    }
                });
                button.disabled = false;
                text.innerText = 'Place Order';
                spinner.classList.add('hidden');
                icon.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Koneksi',
                text: 'Gagal menghubungi server. Silakan periksa koneksi internet Anda.',
                confirmButtonColor: '#111318',
                customClass: {
                    popup: 'rounded-2xl font-sans',
                    title: 'font-serif italic font-bold text-lg',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest text-[10px]'
                }
            });
            button.disabled = false;
            text.innerText = 'Place Order';
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        });
    };

    // Discount Logic
    const discountInput = document.getElementById('discount_code');
    const applyButton = document.getElementById('apply-discount');
    const discountMessage = document.getElementById('discount-message');
    const discountRow = document.getElementById('discount-row');
    const discountAmountSpan = document.getElementById('discount-amount');
    const taxRow = document.getElementById('tax-row');
    const taxAmountSpan = document.getElementById('tax-amount');
    const finalTotalSpan = document.getElementById('final-total');

    applyButton.onclick = function() {
        const code = discountInput.value;
        if (!code) return;

        applyButton.disabled = true;
        applyButton.innerText = '...';

        fetch('{{ route("checkout.check-discount") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            applyButton.disabled = false;
            applyButton.innerText = 'APPLY';
            
            discountMessage.classList.remove('hidden');
            if (data.valid) {
                discountMessage.innerText = data.message;
                discountMessage.className = 'text-[10px] text-green-600 font-bold';
                
                // Update UI
                discountRow.classList.remove('hidden');
                discountAmountSpan.innerText = new Intl.NumberFormat('id-ID').format(data.discount_amount);
                
                if (data.tax_amount > 0) {
                    taxRow.classList.remove('hidden');
                    taxAmountSpan.innerText = new Intl.NumberFormat('id-ID').format(data.tax_amount);
                }

                // Add shipping (15000) to new total
                const totalWithShipping = data.new_total + 15000;
                finalTotalSpan.innerText = new Intl.NumberFormat('id-ID').format(totalWithShipping);
            } else {
                discountMessage.innerText = data.message;
                discountMessage.className = 'text-[10px] text-red-500 font-bold';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            applyButton.disabled = false;
            applyButton.innerText = 'APPLY';
        });
    };
</script>
@endsection
