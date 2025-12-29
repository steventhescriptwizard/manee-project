<section class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:border-brandBlue/30 transition-all group relative overflow-hidden">
    <header class="mb-10 relative z-10">
        <div class="flex items-center gap-4 mb-3">
            <div class="size-12 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-brandBlue/10 transition-colors">
                <span class="material-symbols-outlined text-gray-400 group-hover:text-brandBlue transition-colors">key</span>
            </div>
            <h2 class="text-2xl font-serif font-bold text-[#111318]">
                {{ __('Ubah Kata Sandi') }}
            </h2>
        </div>
        <p class="text-gray-500 text-sm italic font-light">
            {{ __("Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.") }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8 relative z-10">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-2">
                <label for="current_password" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Kata Sandi Saat Ini</label>
                <input id="current_password" name="current_password" type="password" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Kata Sandi Baru</label>
                <input id="password" name="password" type="password" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="block text-[10px] uppercase font-bold tracking-[0.2em] text-gray-400 ml-1">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-black text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-brandBlue transition-all shadow-lg shadow-black/10">
                {{ __('Perbarui Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold italic"
                >{{ __('Kata sandi berhasil diubah.') }}</p>
            @endif
        </div>
    </form>
    
    <div class="absolute right-0 bottom-0 size-32 bg-gray-50/50 rounded-tl-[4rem] -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
</section>
