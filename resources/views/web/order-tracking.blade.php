@extends('layouts.web')

@section('title', 'Lacak Pesanan - Maneé Fashion Store')

@section('content')
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden font-body text-[#111318] bg-[#FCFCFC]"
     x-data="trackingHandler()">

    <section class="flex flex-1 flex-col items-center px-4 py-12 md:px-10 lg:py-20">
        <div class="flex w-full max-w-4xl flex-col gap-10">
            
            <!-- Page Heading & Search Form -->
            <div class="flex flex-col items-center text-center gap-6">
                <div class="space-y-2">
                    <h1 class="font-display text-4xl font-bold tracking-tight text-[#111318] md:text-5xl">
                        Lacak Pesanan Anda
                    </h1>
                    <p class="text-gray-500 max-w-lg mx-auto">
                        Pantau perjalanan paket Maneé Anda dari gudang kami hingga ke tangan Anda. Masukkan nomor pesanan untuk memulai.
                    </p>
                </div>

                <div class="w-full max-w-xl">
                    <div class="relative flex items-center shadow-lg shadow-gray-200/50 rounded-xl bg-white p-2 border border-gray-100">
                        <span class="material-symbols-outlined absolute left-4 text-gray-400">
                            tag
                        </span>
                        <input
                            type="text"
                            x-model="orderNumber"
                            class="h-14 w-full flex-1 border-none bg-transparent pl-12 pr-4 text-base text-[#111318] placeholder:text-gray-400 focus:ring-0 focus:outline-none"
                            placeholder="Contoh: MANEE-2023-8899"
                            @keyup.enter="handleTrack"
                        />
                        <button 
                            @click="handleTrack"
                            class="h-12 shrink-0 rounded-lg bg-brandBlue px-6 font-medium text-white shadow-md shadow-brandBlue/30 hover:bg-opacity-90 transition-all active:scale-95 flex items-center justify-center min-w-[100px]"
                            :disabled="isTracking"
                        >
                            <span x-show="!isTracking">Lacak</span>
                            <span x-show="isTracking" class="animate-pulse">Mencari...</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tracking Result -->
            <div x-show="showResult" 
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="w-full max-w-4xl">
                
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl shadow-gray-200/60 border border-gray-100">
                    
                    <!-- Status Header -->
                    <div class="flex flex-col md:flex-row justify-between p-6 md:p-8 bg-gray-50 border-b border-gray-100 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Nomor Pesanan
                            </p>
                            <p class="text-2xl font-bold font-display text-[#111318] mt-1" x-text="'#' + order.id">
                            </p>
                        </div>
                        <div class="md:text-right">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Estimasi Tiba
                            </p>
                            <p class="text-xl font-bold text-brandBlue mt-1" x-text="order.eta">
                            </p>
                            <p class="text-sm text-gray-400" x-text="'Dikirim via ' + order.courier">
                            </p>
                        </div>
                    </div>

                    <!-- Progress Stepper -->
                    <div class="px-6 py-8 md:px-12">
                        <div class="relative flex flex-col md:flex-row justify-between w-full">
                            <!-- Connecting Lines Desktop -->
                            <div class="absolute top-5 left-0 h-1 w-full bg-gray-100 hidden md:block"></div>
                            <div 
                                class="absolute top-5 left-0 h-1 bg-brandLightBlue hidden md:block transition-all duration-1000"
                                style="width: 66%" 
                            ></div>
                            
                            <!-- Connecting Lines Mobile -->
                            <div class="absolute left-5 top-0 w-1 h-full bg-gray-100 md:hidden"></div>
                            <div 
                                class="absolute left-5 top-0 w-1 bg-brandLightBlue md:hidden"
                                style="height: 60%"
                            ></div>

                            <!-- Steps -->
                            <template x-for="step in steps" :key="step.title">
                                <div class="relative z-10 flex md:flex-col items-center gap-4 md:gap-2 mb-6 md:mb-0 last:mb-0">
                                    <div 
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full shadow-lg ring-4 ring-white transition-all duration-300"
                                        :class="getStepClass(step.status)"
                                    >
                                        <span class="material-symbols-outlined text-sm font-bold" x-text="step.icon"></span>
                                    </div>
                                    <div class="flex flex-col md:items-center">
                                        <p class="text-sm font-bold" 
                                           :class="step.status === 'current' ? 'text-brandBlue' : (step.status === 'pending' ? 'text-gray-400' : 'text-[#111318]')">
                                            <span x-text="step.title"></span>
                                        </p>
                                        <p class="text-xs text-gray-500" x-show="step.status !== 'pending'" x-text="step.date">
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 border-t border-gray-100">
                        
                        <!-- Timeline Section -->
                        <div class="md:col-span-2 p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-100">
                            <h3 class="font-display text-xl font-bold text-[#111318] mb-6">
                                Riwayat Perjalanan
                            </h3>
                            <div class="space-y-6 relative pl-2">
                                <div class="absolute left-[15px] top-2 bottom-2 w-[2px] bg-gray-100"></div>
                                
                                <template x-for="(event, index) in order.timeline" :key="event.id">
                                    <div class="relative flex gap-4" :class="index > 0 ? 'opacity-70' : ''">
                                        <div class="absolute -left-1 mt-1.5 h-3 w-3 rounded-full ring-4 ring-white"
                                             :class="event.status === 'current' ? 'bg-brandBlue' : 'bg-gray-300'"></div>
                                        <div class="pl-4">
                                            <p class="text-sm font-medium"
                                               :class="event.status === 'current' ? 'font-bold text-[#111318]' : 'text-[#111318]'"
                                               x-text="event.title"></p>
                                            <p class="text-xs text-gray-500 mb-1" x-text="event.location"></p>
                                            <p class="text-xs font-medium text-gray-400" x-text="event.date + ' - ' + event.time"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Product Info Section -->
                        <div class="p-6 md:p-8 bg-gray-50/50">
                            <h3 class="font-display text-xl font-bold text-[#111318] mb-6">
                                Rincian Pesanan
                            </h3>
                            <div class="flex gap-4 items-start">
                                <div class="h-24 w-20 shrink-0 overflow-hidden rounded-lg bg-gray-200">
                                    <img 
                                        :src="order.product.imageUrl" 
                                        :alt="order.product.name"
                                        class="h-full w-full object-cover" 
                                    />
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-[#111318] leading-tight" x-text="order.product.name"></p>
                                    <p class="text-xs text-gray-500 mt-1" x-text="'Size: ' + order.product.size"></p>
                                    <p class="text-xs text-gray-500" x-text="'Qty: ' + order.product.qty"></p>
                                    <p class="text-sm font-medium text-[#111318] mt-2" x-text="order.product.price"></p>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brandLightBlue/30 text-brandBlue">
                                        <span class="material-symbols-outlined text-[20px]">
                                            support_agent
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#111318]">
                                            Butuh Bantuan?
                                        </p>
                                        <a href="#" class="text-xs text-brandBlue hover:underline">
                                            Hubungi CS Kami
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    function trackingHandler() {
        return {
            orderNumber: 'MANEE-2023-8899',
            isTracking: false,
            showResult: true, // Show by default for demo purpose as per mock
            order: {
                id: "MANEE-2023-8899",
                eta: "25 Oktober 2023",
                courier: "JNE Express",
                timeline: [
                    {
                        id: "t1",
                        title: "Paket keluar dari Fasilitas Transit",
                        location: "Jakarta Hub, ID",
                        date: "24 Okt 2023",
                        time: "08:45 WIB",
                        status: "current"
                    },
                    {
                        id: "t2",
                        title: "Paket diterima di Fasilitas Transit",
                        location: "Jakarta Hub, ID",
                        date: "23 Okt 2023",
                        time: "19:20 WIB",
                        status: "completed"
                    },
                    {
                        id: "t3",
                        title: "Paket telah dikirim oleh Pengirim",
                        location: "Bandung Warehouse",
                        date: "22 Okt 2023",
                        time: "16:00 WIB",
                        status: "completed"
                    }
                ],
                product: {
                    name: "Cormorant Linen Dress - Beige",
                    size: "M",
                    qty: 1,
                    price: "Rp 459.000",
                    imageUrl: "https://lh3.googleusercontent.com/aida-public/AB6AXuDonYnngvFts9__860uLy2sOBteK8WxrxOckAIijLL8bnSCe60lHxq_22NOMF_gPO3luD50l4ZohvUPqcV-gnNk9Ga8b-b5Ic8Qkp_g5PLlKvo2bsiuB6QhhsyojdFy1vKhGLtFfWO65Ivr4P3ly1-Zu2h3S3Zm-vDrCfX0ceB1Q7U-8PXPLvJgkWHc4VVe8HeXdWVWiyfaq8VoBzCs_Cq9NdIS13WAjRd6F3DEoGtIPUcDInno0Lw-U9qA2E-ZUoPrRpOUH3YKbtM"
                }
            },
            steps: [
                { icon: "check", title: "Dikonfirmasi", date: "22 Okt, 09:00", status: "completed" },
                { icon: "inventory_2", title: "Diproses", date: "22 Okt, 14:30", status: "completed" },
                { icon: "local_shipping", title: "Dalam Pengiriman", date: "Sedang berlangsung", status: "current" },
                { icon: "home", title: "Terkirim", date: "--", status: "pending" }
            ],
            handleTrack() {
                this.isTracking = true;
                setTimeout(() => {
                    this.isTracking = false;
                    this.showResult = true; // Simulating result found
                }, 800);
            },
            getStepClass(status) {
                if (status === 'completed') return 'bg-brandBlue text-white';
                if (status === 'current') return 'bg-brandBlue text-white shadow-brandLightBlue animate-pulse';
                return 'bg-gray-200 text-gray-400';
            }
        }
    }
</script>
@endsection
