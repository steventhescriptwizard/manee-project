@extends('layouts.admin')

@section('title', 'Tambah Admin - Maneé Admin')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="size-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-400 hover:text-blue-600 transition-all shadow-sm">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Tambah Admin</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Buat akun administrator baru</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-xl shadow-slate-200/50 dark:shadow-none overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
            @csrf

            {{-- Profile Upload Section --}}
            <div class="p-8 border-b border-slate-100 dark:border-gray-800 flex flex-col items-center justify-center gap-4 bg-slate-50/50 dark:bg-gray-800/20" x-data="{ photoName: null, photoPreview: null }">
                <div class="relative group">
                    <div class="size-24 rounded-3xl border-4 border-white dark:border-gray-900 shadow-lg overflow-hidden bg-slate-100 dark:bg-gray-800">
                        <template x-if="!photoPreview">
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-4xl">person</span>
                            </div>
                        </template>
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>
                    
                    <input type="file" name="avatar" class="hidden" x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    ">
                    
                    <button type="button" class="absolute -bottom-2 -right-2 size-8 bg-blue-600 text-white rounded-xl shadow-lg flex items-center justify-center hover:scale-110 transition-transform" x-on:click.prevent="$refs.photo.click()">
                        <span class="material-symbols-outlined text-[18px]">add_a_photo</span>
                    </button>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Unggah Foto Profil</p>
                @error('avatar') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Jane Doe" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                        @error('name') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Alamat Email</label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="jane@example.com" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                        @error('email') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-100 dark:border-gray-800">
                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kata Sandi</label>
                        <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                        @error('password') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full h-16 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-blue-700 transition-all shadow-2xl shadow-blue-600/30 flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                        <span>Daftarkan Admin</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
