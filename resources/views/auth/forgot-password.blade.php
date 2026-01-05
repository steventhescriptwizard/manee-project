@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi - Maneé')

@section('content')
<div class="flex min-h-screen w-full">
    <!-- Left Column: Image (Desktop Only) -->
    <div class="hidden lg:block lg:w-1/2 relative bg-[#e0e0e0]">
        <img
            alt="Woman posing in minimalist beige clothing with soft lighting"
            class="absolute inset-0 h-full w-full object-cover"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaS0bh6RYAFd9F5cHU6K8xklxvbkUH4bbmYo5ndw0DCrWE7cVk-XB3tVBGTuXqVk9HzMqOnwUV7Qe0JqGiUySnYb00SUtgvkh869pwcfOQqxn_6XaftliFV6zE9H8aM_zd7ofg9ciOItTrtY14AoLPKhVWarf-UMkCM4rmWxAhx_JsMD7N2O4BrEs6e20dQ1ashuKIudNO85zyVM0wN7bsolPaoxrng0mUQHf8ix-CKed2fkTB6-QwtJTEq1yHu-wtbmLXM0ju62E"
        />
        <div class="absolute inset-0 bg-black/5"></div>
    </div>

    <!-- Right Column: Forgot Password Form -->
    <div class="w-full lg:w-1/2 flex flex-col h-screen overflow-y-auto bg-white transition-colors duration-300">
        <!-- Header -->
        <header class="flex items-center justify-between px-8 py-6 sm:px-12 shrink-0">
            <a href="/" class="flex items-center gap-3 text-[#111318] group cursor-pointer">
                <img src="{{ asset('images/Manee Logo_Main.svg') }}" alt="Maneé Logo" class="h-8 w-auto object-contain">
            </a>
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-[#111318] transition-colors">Kembali ke Login</a>
        </header>
        
        <div class="flex-1 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 py-12">
            <div class="max-w-[440px] w-full mx-auto flex flex-col gap-8">
                <div class="text-center sm:text-left">
                    <h1 class="text-4xl md:text-[40px] font-bold font-serif leading-tight text-[#111318] mb-4">
                        Lupa Kata Sandi?
                    </h1>
                    <p class="text-base text-gray-500 leading-normal">
                        Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset kata sandi.
                    </p>
                </div>
                
                <!-- Session Status -->
                @if (session('status'))
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-50 to-white border border-green-100 p-5 shadow-sm animate-in fade-in zoom-in-95 duration-500">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-100/30 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                        
                        <div class="relative flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-500 flex items-center justify-center shadow-lg shadow-green-200">
                                <span class="material-symbols-outlined text-white text-[24px]">check_circle</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-green-900 leading-tight">Email Terkirim!</p>
                                <p class="text-[12px] text-green-600 font-medium mt-1 leading-snug">
                                    {{ session('status') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
                    @csrf

                    <!-- Email Address -->
                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-sm font-bold text-[#111318]">Alamat Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">mail</span>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                placeholder="nama@email.com"
                                class="w-full h-12 pl-12 pr-4 rounded-xl border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-black/5 focus:border-black transition-all text-sm font-medium"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <button type="submit" class="w-full h-14 bg-black text-white rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-gray-900 transition-all shadow-lg shadow-black/10 active:scale-[0.98] mt-2">
                        Kirim Link Reset Password
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-500">
                        Ingat kata sandi Anda? 
                        <a href="{{ route('login') }}" class="font-bold text-[#111318] hover:underline underline-offset-4 decoration-2 decoration-black/20 transition-all ml-1">
                            Login
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <footer class="py-10 px-8 text-center shrink-0">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest flex items-center justify-center gap-2">
                © 2024 <img src="{{ asset('images/Manee Logo_Main.svg') }}" alt="Maneé Logo" class="h-4 w-auto opacity-50 grayscale"> All rights reserved.
            </p>
        </footer>
    </div>
</div>
@endsection
