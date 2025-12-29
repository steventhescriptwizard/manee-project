<section class="bg-red-50/30 p-8 rounded-[2rem] border border-red-100 shadow-sm hover:border-red-200 transition-all group relative overflow-hidden">
    <header class="mb-10 relative z-10">
        <div class="flex items-center gap-4 mb-3">
            <div class="size-12 rounded-2xl bg-white flex items-center justify-center group-hover:bg-red-100 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-red-400 group-hover:text-red-500 transition-colors">delete_forever</span>
            </div>
            <h2 class="text-2xl font-serif font-bold text-red-900">
                {{ __('Hapus Akun') }}
            </h2>
        </div>
        <p class="text-red-700/70 text-sm italic font-light max-w-2xl">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <div class="relative z-10">
        <button
            class="bg-red-600 text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-black transition-all shadow-lg shadow-red-200"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Hapus Akun Permanen') }}</button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-serif font-bold text-gray-900">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-4 text-sm text-gray-500 italic font-light">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-8 space-y-2">
                <label for="password_deletion" class="sr-only">Kata Sandi</label>

                <input
                    id="password_deletion"
                    name="password"
                    type="password"
                    class="w-full h-14 px-6 rounded-2xl border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-brandBlue/5 focus:border-brandBlue focus:outline-none transition-all text-sm font-bold"
                    placeholder="{{ __('Masukkan kata sandi Anda...') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-8 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs text-gray-500 hover:bg-gray-100 transition-all">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="bg-red-600 text-white px-8 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-black transition-all shadow-lg">
                    {{ __('Hapus Sekarang') }}
                </button>
            </div>
        </form>
    </x-modal>
    
    <div class="absolute right-0 bottom-0 size-32 bg-white/50 rounded-tl-[4rem] -z-0 group-hover:bg-red-100/50 transition-colors"></div>
</section>
