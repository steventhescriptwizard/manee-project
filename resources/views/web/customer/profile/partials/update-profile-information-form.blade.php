<section class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:border-brandBlue/30 transition-all group relative overflow-hidden">
    <header class="mb-10 relative z-10">
        <div class="flex items-center gap-4 mb-3">
            <div class="size-12 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-brandBlue/10 transition-colors">
                <span class="material-symbols-outlined text-gray-400 group-hover:text-brandBlue transition-colors">contact_page</span>
            </div>
            <h2 class="text-2xl font-serif font-bold text-[#111318]">
                {{ __('Informasi Profil') }}
            </h2>
        </div>
        <p class="text-gray-500 text-sm italic font-light">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8 relative z-10">
        @csrf
        @method('patch')

        {{-- Avatar Upload Section --}}
        <div class="flex flex-col items-center justify-center gap-4 mb-8" x-data="{ photoName: null, photoPreview: null }">
            <div class="relative group">
                <div class="size-32 rounded-3xl border-4 border-white shadow-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                    <template x-if="!photoPreview">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-gray-300 text-5xl">person</span>
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
                
                <button type="button" class="absolute -bottom-2 -right-2 size-10 bg-black text-white rounded-2xl shadow-lg flex items-center justify-center hover:scale-110 transition-transform" x-on:click.prevent="$refs.photo.click()">
                    <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
                </button>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Foto Profil') }}</p>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="name" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Nama Lengkap</label>
                <input id="name" name="name" type="text" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold italic" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Email</label>
                <input id="email" name="email" type="email" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold italic" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Email Anda belum terverifikasi.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Phone --}}
            <div class="space-y-2">
                <label for="phone" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Nomor Telepon</label>
                <input id="phone" name="phone" type="text" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold italic" value="{{ old('phone', $user->customer?->phone) }}" placeholder="0812..." />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            {{-- Gender --}}
            <div class="space-y-2">
                <label for="gender" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Jenis Kelamin</label>
                <select id="gender" name="gender" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold italic appearance-none">
                    <option value="">Pilih...</option>
                    <option value="male" {{ old('gender', $user->customer?->gender) === 'male' ? 'selected' : '' }}>Pria</option>
                    <option value="female" {{ old('gender', $user->customer?->gender) === 'female' ? 'selected' : '' }}>Wanita</option>
                    <option value="other" {{ old('gender', $user->customer?->gender) === 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            {{-- Date of Birth --}}
            <div class="space-y-2">
                <label for="date_of_birth" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Tanggal Lahir</label>
                <input id="date_of_birth" name="date_of_birth" type="date" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold italic" value="{{ old('date_of_birth', $user->customer?->date_of_birth) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-black text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-brandBlue transition-all shadow-lg shadow-black/10">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold italic"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
    
    <div class="absolute right-0 bottom-0 size-32 bg-gray-50/50 rounded-tl-[4rem] -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
</section>
