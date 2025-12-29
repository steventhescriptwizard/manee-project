@extends('layouts.admin')

@section('title', 'Edit Pelanggan - ' . $customer->name)

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.customers.index') }}" class="size-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 text-slate-400 hover:text-blue-600 transition-all shadow-sm">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Edit Pelanggan</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Sesuaikan informasi akun {{ $customer->name }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-slate-200 dark:border-gray-800 shadow-xl shadow-slate-200/50 dark:shadow-none overflow-hidden">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
            @csrf
            @method('PUT')

            {{-- Profile Upload Section --}}
            <div class="p-8 border-b border-slate-100 dark:border-gray-800 flex flex-col items-center justify-center gap-4 bg-slate-50/50 dark:bg-gray-800/20" x-data="{ photoName: null, photoPreview: null }">
                <div class="relative group">
                    <div class="size-32 rounded-3xl border-4 border-white dark:border-gray-900 shadow-lg overflow-hidden bg-slate-100 dark:bg-gray-800">
                        <template x-if="!photoPreview">
                            @if($customer->avatar)
                                <img src="{{ Storage::url($customer->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <span class="material-symbols-outlined text-5xl">person</span>
                                </div>
                            @endif
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
                    
                    <button type="button" class="absolute -bottom-2 -right-2 size-10 bg-blue-600 text-white rounded-2xl shadow-lg flex items-center justify-center hover:scale-110 transition-transform" x-on:click.prevent="$refs.photo.click()">
                        <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
                    </button>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Ubah Foto Profil</p>
                    <p class="text-[9px] text-slate-400 mt-1 uppercase tracking-tight">Format: JPG, PNG, GIF (Max. 2MB)</p>
                </div>
                @error('avatar') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col gap-2 text-slate-400">
                        <label for="name" class="text-xs font-black uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $customer->name) }}" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                        @error('name') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2 text-slate-400">
                        <label for="email" class="text-xs font-black uppercase tracking-widest">Alamat Email</label>
                        <input type="email" name="email" id="email" required value="{{ old('email', $customer->email) }}" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                        @error('email') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Related User Section --}}
                <div class="pt-8 border-t border-slate-100 dark:border-gray-800">
                    <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30 p-5 rounded-2xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-1">Akun User Terkait</p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 font-bold">Terhubung dengan User ID: <span class="text-slate-900 dark:text-white">#{{ $customer->id }}</span> ({{ $customer->email }})</p>
                        </div>
                        <div class="size-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                            <span class="material-symbols-outlined">link</span>
                        </div>
                    </div>
                </div>

                {{-- Customer Profile Details --}}
                <div class="pt-8 border-t border-slate-100 dark:border-gray-800">
                    <h3 class="text-xs font-black text-blue-600 uppercase tracking-[0.2em] mb-6">Informasi Profil Pelanggan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-2">
                            <label for="phone" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->customer?->phone) }}" placeholder="0812..." class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 text-sm font-bold text-slate-900 dark:text-white">
                            @error('phone') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="tier" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tier Pelanggan</label>
                            <select name="tier" id="tier" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900">
                                @foreach(['regular', 'silver', 'gold', 'platinum'] as $t)
                                    <option value="{{ $t }}" {{ old('tier', $customer->customer?->tier) == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                            @error('tier') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="gender" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900">
                                <option value="">Pilih</option>
                                <option value="male" {{ old('gender', $customer->customer?->gender) == 'male' ? 'selected' : '' }}>Pria</option>
                                <option value="female" {{ old('gender', $customer->customer?->gender) == 'female' ? 'selected' : '' }}>Wanita</option>
                                <option value="other" {{ old('gender', $customer->customer?->gender) == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('gender') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="date_of_birth" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $customer->customer?->date_of_birth) }}" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900">
                            @error('date_of_birth') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Address Information --}}
                @php
                    $primaryAddress = $customer->customer?->addresses->where('is_primary', true)->first();
                @endphp
                <div class="pt-8 border-t border-slate-100 dark:border-gray-800">
                    <h3 class="text-xs font-black text-blue-600 uppercase tracking-[0.2em] mb-6">Alamat Utama</h3>
                    <div class="space-y-8">
                        <div class="flex flex-col gap-2">
                            <label for="address_line" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Alamat Lengkap</label>
                            <textarea name="address_line" id="address_line" rows="3" placeholder="Nama Jalan, No. Rumah, dll" class="w-full p-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 text-sm font-bold">{{ old('address_line', $primaryAddress?->address_line) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="flex flex-col gap-2">
                                <label for="city" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kota</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $primaryAddress?->city) }}" placeholder="Jakarta" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 text-sm font-bold">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="province" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Provinsi</label>
                                <input type="text" name="province" id="province" value="{{ old('province', $primaryAddress?->province) }}" placeholder="DKI Jakarta" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 text-sm font-bold">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="postal_code" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kode Pos</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $primaryAddress?->postal_code) }}" placeholder="12345" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 text-sm font-bold">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="pt-8 border-t border-slate-100 dark:border-gray-800">
                    <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/30 p-4 rounded-xl mb-6">
                        <p class="text-[10px] font-black text-amber-600 dark:text-amber-500 uppercase tracking-widest mb-1">Keamanan</p>
                        <p class="text-xs text-amber-700 dark:text-amber-400 font-medium leading-relaxed">Kosongkan kolom password di bawah jika Anda tidak ingin mengubah kata sandi pelanggan.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-2">
                            <label for="password" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                            @error('password') <span class="text-xs text-red-500 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="password_confirmation" class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="w-full h-14 px-5 rounded-2xl border-slate-200 dark:border-gray-800 bg-slate-50 dark:bg-gray-800/50 focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all text-sm font-bold text-slate-900 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full h-16 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-blue-700 transition-all shadow-2xl shadow-blue-600/30 flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
