@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="max-w-[1000px] mx-auto" x-data="{ activeTab: 'general' }">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Pengaturan</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola konfigurasi toko dan preferensi sistem.</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 overflow-x-auto border-b border-slate-200 dark:border-gray-800 mb-6 no-scrollbar">
        @foreach(['general' => 'Umum', 'language' => 'Bahasa', 'homepage' => 'Halaman Depan', 'payment' => 'Pembayaran', 'shipping' => 'Pengiriman'] as $key => $label)
        <button 
            @click="activeTab = '{{ $key }}'"
            :class="{ 'border-blue-600 text-blue-600': activeTab === '{{ $key }}', 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== '{{ $key }}' }"
            class="pb-3 px-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap"
        >
            {{ $label }}
        </button>
        @endforeach
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="confirm-save">
        @csrf

        <!-- General Settings -->
        <div x-show="activeTab === 'general'" class="space-y-6">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Identitas Toko</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Toko</label>
                        <input type="text" name="site_name" value="{{ setting('site_name', 'Maneé Store') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email Kontak</label>
                        <input type="email" name="site_email" value="{{ setting('site_email') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Alamat Lengkap</label>
                        <textarea name="site_address" rows="3" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">{{ setting('site_address') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Logo Toko</label>
                        <input type="file" name="site_logo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if(setting('site_logo'))
                            <div class="mt-2">
                                <img src="{{ Storage::url(setting('site_logo')) }}" alt="Logo" class="h-12 object-contain">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Settings -->
        <div x-show="activeTab === 'language'" class="space-y-6" style="display: none;">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Language / Bahasa</h3>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Application Language</label>
                        <select name="app_locale" class="w-full md:w-1/2 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="en" {{ setting('app_locale', 'en') === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                            <option value="id" {{ setting('app_locale') === 'id' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
                        </select>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Select the language for the admin dashboard interface.</p>
                    </div>

                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-[20px] mt-0.5">info</span>
                            <div class="text-sm text-blue-900 dark:text-blue-300">
                                <p class="font-semibold mb-1">Note:</p>
                                <p>Changing the language will update all menu labels and interface text in the admin dashboard. The customer-facing website language can be configured separately.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'homepage'" class="space-y-8" style="display: none;">
            
            <!-- Hero Section -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b pb-2">Hero Section</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-4">
                         <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Gambar Slider</label>
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @for($i = 1; $i <= 3; $i++)
                            <div class="space-y-2">
                                <label class="text-xs text-slate-500">Slide {{ $i }}</label>
                                <input type="file" name="hero_slide_{{ $i }}" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-blue-50 file:text-blue-700">
                                @if(setting("hero_slide_{$i}"))
                                    <div class="mt-1 aspect-video rounded overflow-hidden bg-gray-100 relative group">
                                         <img src="{{ Storage::url(setting("hero_slide_{$i}")) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                            @endfor
                         </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Headline</label>
                        <textarea name="hero_headline" rows="2" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">{{ setting('hero_headline') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Subheadline</label>
                        <textarea name="hero_subheadline" rows="2" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">{{ setting('hero_subheadline') }}</textarea>
                    </div>
                     <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">CTA Text</label>
                        <input type="text" name="hero_cta_text" value="{{ setting('hero_cta_text') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    </div>
                     <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">CTA Link</label>
                        <input type="text" name="hero_cta_link" value="{{ setting('hero_cta_link', '#') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    </div>
                </div>
            </div>

            <!-- Promo Section -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white border-b pb-2">Promo Section</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div class="md:col-span-2 space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Background Image</label>
                         <input type="file" name="promo_image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if(setting('promo_image'))
                            <div class="mt-2 h-32 w-full rounded overflow-hidden bg-gray-100">
                                <img src="{{ Storage::url(setting('promo_image')) }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Promo Title</label>
                        <input type="text" name="promo_title" value="{{ setting('promo_title', 'Receive 10% Off') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    </div>
                     <div class="space-y-1">
                         <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Promo Button Text</label>
                         <input type="text" name="promo_button_text" value="{{ setting('promo_button_text', 'Register Now') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                     </div>
                     <div class="space-y-1 md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Promo Description</label>
                        <textarea name="promo_text" rows="3" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">{{ setting('promo_text', "Enjoy 10% off your first purchase,\nand other promotional offers\nby becoming our members.") }}</textarea>
                    </div>
                     <div class="space-y-1 md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Promo Button Link</label>
                        <input type="text" name="promo_button_link" value="{{ setting('promo_button_link', '#') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Settings -->
        <div x-show="activeTab === 'payment'" class="space-y-6" style="display: none;">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Midtrans Payment Gateway</h3>
                    <img src="{{ asset('images/Midtrans.webp') }}" class="h-6 object-contain" alt="Midtrans">
                </div>
                
                <div class="space-y-4">
                     <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Environment</label>
                        <select name="payment_midtrans_mode" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="sandbox" {{ setting('payment_midtrans_mode') == 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                            <option value="production" {{ setting('payment_midtrans_mode') == 'production' ? 'selected' : '' }}>Production (Live)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Server Key</label>
                        <input type="password" name="payment_midtrans_server_key" value="{{ setting('payment_midtrans_server_key') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="SB-Mid-server-...">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Client Key</label>
                        <input type="text" name="payment_midtrans_client_key" value="{{ setting('payment_midtrans_client_key') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="SB-Mid-client-...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Settings -->
        <div x-show="activeTab === 'shipping'" class="space-y-6" style="display: none;">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Pengaturan Pengiriman</h3>
                
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tarif Ongkir Flat (Default)</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="shipping_base_rate" value="{{ setting('shipping_base_rate', 15000) }}" class="pl-10 w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Tarif ini digunakan jika tidak ada perhitungan otomatis kurir.</p>
                    </div>

                    <div class="space-y-3 pt-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block">Kurir Aktif</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['jne' => 'JNE', 'tiki' => 'TIKI', 'pos' => 'POS Indonesia', 'sicepat' => 'SiCepat'] as $code => $name)
                            <label class="inline-flex items-center">
                                <input type="hidden" name="shipping_courier_{{ $code }}" value="0">
                                <input type="checkbox" name="shipping_courier_{{ $code }}" value="1" {{ setting("shipping_courier_{$code}", '1') ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">{{ $name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Submit Button -->
        <div class="sticky bottom-4 mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
