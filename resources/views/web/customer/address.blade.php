@extends('web.customer.layouts.app')

@section('header_title', 'Alamat Saya')
@section('header_subtitle', 'Kelola alamat pengiriman Anda untuk pengalaman belanja yang lebih cepat.')

@section('customer_content')
<div class="space-y-8 animate-fade-in" x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editingAddress: null,
    openEditModal(address) {
        this.editingAddress = address;
        this.showEditModal = true;
    }
}">
    {{-- Header & Add Button --}}
    <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between mb-8">
        <div>
            <h3 class="font-serif text-3xl font-bold text-[#111318]">
                Daftar Alamat
            </h3>
            <p class="text-gray-400 text-sm italic font-light mt-1">
                Anda dapat menyimpan beberapa alamat pengiriman.
            </p>
        </div>
        <button @click="showAddModal = true" class="w-full md:w-auto px-8 py-4 rounded-2xl bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-brandBlue transition-all shadow-lg shadow-black/10 flex items-center justify-center gap-2 group">
            <span class="material-symbols-outlined text-[20px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Alamat Baru
        </button>
    </div>


    {{-- Address Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($addresses as $address)
            <div class="bg-white rounded-[2rem] border-2 {{ $address->is_primary ? 'border-brandBlue/20 shadow-xl' : 'border-gray-100 shadow-sm' }} p-8 relative overflow-hidden group hover:border-brandBlue/20 hover:shadow-xl transition-all h-full flex flex-col">
                @if($address->is_primary)
                    <div class="absolute top-0 right-0 mt-6 mr-6">
                        <span class="px-4 py-1.5 rounded-full bg-brandBlue text-white text-[10px] font-bold uppercase tracking-widest shadow-md shadow-brandBlue/20">
                            Utama
                        </span>
                    </div>
                @endif

                <div class="flex flex-col h-full relative z-10 flex-1">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="size-12 rounded-2xl {{ $address->is_primary ? 'bg-brandBlue/5 text-brandBlue' : 'bg-gray-50 text-gray-400 group-hover:bg-brandBlue/5 group-hover:text-brandBlue' }} flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined">
                                {{ strtolower($address->label) === 'rumah' ? 'home_pin' : (strtolower($address->label) === 'kantor' ? 'work' : 'location_on') }}
                            </span>
                        </div>
                        <h4 class="text-xl font-serif font-bold text-[#111318]">{{ $address->label }}</h4>
                    </div>

                    <div class="space-y-4 flex-1">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Penerima</p>
                            <p class="font-bold text-[#111318] italic">{{ $address->recipient_name }}</p>
                            <p class="text-xs text-gray-500 font-light mt-1 italic">{{ $address->phone_number }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Alamat Lengkap</p>
                            <p class="text-sm text-gray-500 font-light leading-relaxed italic">
                                {{ $address->address_line }}<br>
                                {{ $address->city }}, {{ $address->province }}<br>
                                {{ $address->postal_code }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-10">
                        <button @click="openEditModal({{ json_encode($address) }})" class="flex-1 px-4 py-3 rounded-xl border border-gray-100 bg-white text-[10px] font-bold uppercase tracking-widest text-[#111318] hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            Edit
                        </button>
                        
                        @if(!$address->is_primary)
                            <form action="{{ route('customer.address.set-primary', $address->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-white text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-brandBlue hover:border-brandBlue/20 transition-all">
                                    Set Utama
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('customer.address.destroy', $address->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn px-4 py-3 rounded-xl border border-gray-100 bg-white text-gray-400 hover:text-brandRed hover:border-brandRed/20 transition-all">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="absolute -right-6 -bottom-6 size-24 {{ $address->is_primary ? 'bg-brandBlue/5' : 'bg-gray-50 group-hover:bg-brandBlue/5' }} rounded-full -z-0 transition-colors"></div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-[2.5rem] border border-gray-100 p-16 text-center shadow-sm">
                <div class="size-24 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-8">
                    <span class="material-symbols-outlined text-5xl text-gray-200">location_off</span>
                </div>
                <h4 class="text-2xl font-serif font-bold text-[#111318] mb-3 italic">Belum Ada Alamat</h4>
                <p class="text-gray-400 max-w-sm mx-auto mb-10 font-light italic">
                    Simpan alamat Anda sekarang untuk memudahkan proses pengiriman pesanan Maneé Anda di masa depan.
                </p>
                <button @click="showAddModal = true" class="bg-black text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-brandBlue transition-all shadow-lg">
                    Tambahkan Alamat Pertama
                </button>
            </div>
        @endforelse
    </div>

    {{-- Add Address Modal --}}
    <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showAddModal = false"></div>

            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-[3rem] w-full max-w-2xl">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-3xl font-serif font-bold text-[#111318] italic">Tambah Alamat</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-black transition-colors">
                        <span class="material-symbols-outlined text-[32px]">close</span>
                    </button>
                </div>

                <form action="{{ route('customer.address.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-full">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Label Alamat (Rumah/Kantor)</label>
                            <input type="text" name="label" required placeholder="Contoh: Rumah Utama" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Penerima</label>
                            <input type="text" name="recipient_name" required value="{{ Auth::user()->name }}" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nomor Telepon</label>
                            <input type="text" name="phone_number" required placeholder="08123456789" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                        </div>
                        <div class="col-span-full">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                            <textarea name="address_line" required rows="3" placeholder="Nama jalan, nomor rumah, kompleks" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Kota</label>
                            <input type="text" name="city" required class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Provinsi</label>
                            <input type="text" name="province" required class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Kode Pos</label>
                            <input type="text" name="postal_code" required class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                        </div>
                        <div class="flex items-center gap-3 ml-1">
                            <input type="checkbox" name="is_primary" value="1" id="add_is_primary" class="size-5 rounded-lg border-gray-200 text-brandBlue focus:ring-brandBlue">
                            <label for="add_is_primary" class="text-sm font-bold text-gray-500 italic">Jadikan Alamat Utama</label>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-10">
                        <button type="button" @click="showAddModal = false" class="flex-1 px-8 py-5 rounded-2xl border border-gray-100 font-bold uppercase tracking-widest text-xs text-gray-400 hover:bg-gray-50 transition-all">Batal</button>
                        <button type="submit" class="flex-[2] px-8 py-5 rounded-2xl bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-brandBlue transition-all shadow-xl shadow-black/10">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Address Modal --}}
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="showEditModal = false"></div>

            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-[3rem] w-full max-w-2xl">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-3xl font-serif font-bold text-[#111318] italic">Edit Alamat</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-black transition-colors">
                        <span class="material-symbols-outlined text-[32px]">close</span>
                    </button>
                </div>

                <template x-if="editingAddress">
                    <form :action="`/customer/address/${editingAddress.id}`" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-full">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Label Alamat (Rumah/Kantor)</label>
                                <input type="text" name="label" required :value="editingAddress.label" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Penerima</label>
                                <input type="text" name="recipient_name" required :value="editingAddress.recipient_name" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Nomor Telepon</label>
                                <input type="text" name="phone_number" required :value="editingAddress.phone_number" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                            </div>
                            <div class="col-span-full">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                                <textarea name="address_line" required rows="3" x-text="editingAddress.address_line" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]"></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Kota</label>
                                <input type="text" name="city" required :value="editingAddress.city" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Provinsi</label>
                                <input type="text" name="province" required :value="editingAddress.province" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Kode Pos</label>
                                <input type="text" name="postal_code" required :value="editingAddress.postal_code" class="w-full px-6 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:border-brandBlue focus:ring-0 transition-all font-serif italic text-[#111318]">
                            </div>
                            <div class="flex items-center gap-3 ml-1">
                                <input type="checkbox" name="is_primary" value="1" id="edit_is_primary" :checked="editingAddress.is_primary == 1" class="size-5 rounded-lg border-gray-200 text-brandBlue focus:ring-brandBlue">
                                <label for="edit_is_primary" class="text-sm font-bold text-gray-500 italic">Jadikan Alamat Utama</label>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-10">
                            <button type="button" @click="showEditModal = false" class="flex-1 px-8 py-5 rounded-2xl border border-gray-100 font-bold uppercase tracking-widest text-xs text-gray-400 hover:bg-gray-50 transition-all">Batal</button>
                            <button type="submit" class="flex-[2] px-8 py-5 rounded-2xl bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-brandBlue transition-all shadow-xl shadow-black/10">Simpan Perubahan</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
