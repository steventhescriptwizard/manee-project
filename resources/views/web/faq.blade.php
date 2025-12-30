@extends('layouts.web')

@section('title', 'FAQ - Pertanyaan yang Sering Diajukan - Maneé Fashion Store')

@section('content')
<div class="relative flex min-h-screen flex-col font-body text-[#111318] bg-white"
     x-data="faqHandler()">

    <!-- Hero Section -->
    <section class="relative bg-white pt-12 pb-8 border-b border-transparent">
        <div class="w-full max-w-4xl mx-auto px-4 text-center">
            <p class="text-brandBlue font-medium tracking-wider uppercase text-xs mb-3">
                Customer Care
            </p>
            <h1 class="text-4xl md:text-5xl font-display font-bold mb-4 text-[#111318]">
                Pertanyaan yang Sering Diajukan
            </h1>
            <p class="text-gray-600 max-w-lg mx-auto mb-8 leading-relaxed">
                Temukan jawaban cepat seputar pemesanan, pengiriman, dan produk Maneé agar pengalaman belanjamu lebih nyaman.
            </p>
            
            <!-- Search Bar -->
            <div class="relative max-w-xl mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-500 text-[24px]">search</span>
                </div>
                <input
                    type="text"
                    class="block w-full pl-12 pr-4 py-4 rounded-xl border-none bg-gray-50 focus:ring-2 focus:ring-brandBlue shadow-sm placeholder:text-gray-400 text-base transition-all"
                    placeholder="Cari topik (misal: pengiriman, ukuran, retur)..."
                    x-model="searchQuery"
                />
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="bg-white pb-20">
        <div class="max-w-5xl mx-auto px-4 md:px-8">
            
            <!-- Tabs -->
            <div class="flex overflow-x-auto pb-4 mb-8 border-b border-gray-100 gap-8 hide-scrollbar">
                <template x-for="category in categories" :key="category">
                    <button
                        @click="activeCategory = category; searchQuery = ''"
                        class="whitespace-nowrap pb-3 border-b-2 font-medium transition-all duration-200"
                        :class="activeCategory === category && searchQuery === '' ? 'border-brandBlue text-[#111318] font-bold' : 'border-transparent text-gray-500 hover:text-[#111318]'"
                        x-text="category"
                    ></button>
                </template>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                
                <!-- Sidebar -->
                <div class="md:col-span-4 lg:col-span-3 space-y-6">
                    <div class="bg-brandLightBlue/20 p-6 rounded-xl">
                        <h3 class="font-display text-xl font-bold mb-2">
                            Butuh Bantuan Lain?
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Tim CS kami siap membantu Anda Senin - Jumat, 09.00 - 17.00 WIB.
                        </p>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="flex items-center gap-2 text-sm font-bold text-[#111318] hover:underline group">
                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">
                                chat
                            </span>
                            Chat WhatsApp
                        </a>
                        <a href="mailto:support@manee.com"
                            class="flex items-center gap-2 text-sm font-bold text-[#111318] hover:underline mt-2 group">
                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">
                                mail
                            </span>
                            Email Kami
                        </a>
                    </div>

                    <!-- Image Banner -->
                    <div class="hidden md:block relative h-64 rounded-xl overflow-hidden group cursor-pointer">
                        <img
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkB_SohtvckblTr9nHxDLTPxTSxIB4atqdvt9xbY_zl7fEUROZcN_81_KMy8bwdVE-HbIbgUhf7LRTWCUzGjkTS8IRHk80iMk0Y94B0hqRPF5agmzvcRMljedeZEpXAK6O3ruvNZlFFbNVZxRRirCRBWtpQBqDzEjmhmGEyFnMjXtsZ0a24LkpCIj7t6gOhoTzwJm82qc5O7Uj3Jqd6pqHhur_NGwNw4RmHWRCaHJpaafdreL0XBwbxcVu8Ta2UsF95I8Xdplmvrk"
                            alt="Stylish clothing minimalist layout"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <p class="font-display text-lg font-bold">Koleksi Baru</p>
                            <p class="text-xs opacity-90 group-hover:translate-x-1 transition-transform">
                                Lihat selengkapnya →
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Main FAQ List -->
                <div class="md:col-span-8 lg:col-span-9">
                    <div class="flex flex-col gap-4">
                        
                        <!-- Empty State -->
                        <div x-show="searchQuery && filteredFAQs.length === 0" class="text-center py-10 text-gray-500" style="display: none;">
                            <span class="material-symbols-outlined text-4xl mb-2 opacity-50">search_off</span>
                            <p>Tidak ada hasil untuk "<span x-text="searchQuery"></span>"</p>
                        </div>

                        <!-- FAQ Items -->
                        <template x-for="(faq, index) in filteredFAQs" :key="faq.id">
                            <div class="group bg-white border border-gray-100 rounded-lg overflow-hidden transition-all duration-300"
                                x-data="{ isOpen: index === 0 && !searchQuery }"
                                :class="isOpen ? 'shadow-md' : ''">
                                
                                <button
                                    @click="isOpen = !isOpen"
                                    class="flex cursor-pointer items-center justify-between gap-4 p-5 w-full text-left select-none hover:bg-gray-50 transition-colors"
                                    :aria-expanded="isOpen">
                                    <h3 class="text-base font-medium text-[#111318]" x-text="faq.question"></h3>
                                    <div class="text-gray-500 transition-transform duration-300 flex items-center"
                                        :class="isOpen ? 'rotate-180' : ''">
                                        <span class="material-symbols-outlined">expand_more</span>
                                    </div>
                                </button>
                                
                                <div x-show="isOpen" x-collapse>
                                    <div class="px-5 pb-5 pt-0 text-gray-600 text-sm leading-relaxed" x-text="faq.answer">
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- "See More" Link -->
                    <div class="mt-8 text-center md:text-left" x-show="!searchQuery && filteredFAQs.length > 0">
                        <button class="text-sm font-medium text-brandBlue hover:text-brandBlue/80 transition-colors inline-flex items-center gap-1 group">
                            Lihat pertanyaan lainnya
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">
                                arrow_forward
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    function faqHandler() {
        return {
            activeCategory: 'Umum & Akun',
            searchQuery: '',
            categories: ['Umum & Akun', 'Pemesanan & Pembayaran', 'Pengiriman', 'Retur & Penukaran', 'Produk & Ukuran'],
            allFaqs: [
                {
                    id: "1",
                    category: "Umum & Akun",
                    question: "Bagaimana cara membuat akun di website Maneé?",
                    answer: "Klik ikon pengguna di pojok kanan atas, lalu pilih 'Daftar'. Isi formulir dengan data diri Anda dan klik tombol daftar. Anda akan menerima email konfirmasi setelahnya untuk memverifikasi akun Anda. Pastikan email yang Anda masukkan aktif."
                },
                {
                    id: "2",
                    category: "Umum & Akun",
                    question: "Apakah saya perlu membuat akun untuk berbelanja?",
                    answer: "Tidak wajib. Anda bisa berbelanja sebagai tamu (guest checkout). Namun, dengan membuat akun, Anda dapat melacak riwayat pesanan, menyimpan alamat pengiriman, dan mendapatkan akses lebih cepat ke promo khusus member Maneé."
                },
                {
                    id: "3",
                    category: "Umum & Akun",
                    question: "Lupa kata sandi, bagaimana cara meresetnya?",
                    answer: "Pada halaman login, klik tautan \"Lupa Kata Sandi\". Masukkan alamat email yang terdaftar, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda. Cek folder spam jika email tidak muncul di kotak masuk utama."
                },
                {
                    id: "4",
                    category: "Pengiriman",
                    question: "Bagaimana cara mengubah alamat pengiriman?",
                    answer: "Jika pesanan belum diproses, Anda dapat menghubungi Customer Service kami segera. Namun, jika Anda ingin mengubah alamat untuk pesanan selanjutnya, silakan masuk ke menu 'Akun Saya' dan pilih 'Buku Alamat' untuk mengedit atau menambah alamat baru."
                },
                {
                    id: "5",
                    category: "Umum & Akun",
                    question: "Apakah data pribadi saya aman?",
                    answer: "Tentu saja. Kami menjaga privasi Anda dengan sangat serius. Data Anda dilindungi dengan enkripsi standar industri dan kami tidak pernah membagikan informasi pribadi Anda kepada pihak ketiga tanpa izin, kecuali diperlukan untuk proses pengiriman."
                },
                {
                    id: "6",
                    category: "Pemesanan & Pembayaran",
                    question: "Metode pembayaran apa saja yang tersedia?",
                    answer: "Kami menerima berbagai metode pembayaran termasuk transfer bank (BCA, Mandiri, BNI), kartu kredit/debit (Visa, Mastercard), dan e-wallet (GoPay, OVO, ShopeePay)."
                },
                {
                    id: "7",
                    category: "Retur & Penukaran",
                    question: "Berapa lama batas waktu pengembalian barang?",
                    answer: "Anda dapat mengajukan pengembalian atau penukaran barang maksimal 7 hari setelah barang diterima, dengan syarat kondisi barang masih baru, belum dicuci, dan label masih terpasang."
                }
            ],
            get filteredFAQs() {
                if (this.searchQuery.trim().length > 0) {
                    const query = this.searchQuery.toLowerCase();
                    return this.allFaqs.filter(item => 
                        item.question.toLowerCase().includes(query) || 
                        item.answer.toLowerCase().includes(query)
                    );
                }
                return this.allFaqs.filter(item => item.category === this.activeCategory);
            }
        }
    }
</script>
@endsection
