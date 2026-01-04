<footer class="bg-brandCream border-t border-gray-200 pt-16 pb-12 relative overflow-hidden">
    <!-- Logo Background Watermark -->
    <div class="absolute right-0 bottom-0 opacity-[0.90] pointer-events-none select-none lg:block hidden z-0 translate-x-32 translate-y-32">
        <img src="{{ asset('images/Manee M Footer.svg') }}" alt="Manee Logo" class="w-[800px] h-auto">
    </div>

    <div class="container mx-auto px-6 lg:px-10 relative z-10">
        <!-- Top Section: Address & Google Maps -->
        <div class="flex flex-col lg:flex-row justify-between items-start mb-10">
            <!-- Address -->
            <div>
                <h4 class="font-sans font-bold text-textMain mb-2 text-lg">Visit Our Store</h4>
                <p class="font-sans text-textMain font-light leading-relaxed max-w-md text-base">
                    Jl. Sareh No.5, Kotabaru, Kec. Gondokusuman,<br />
                    Kota Yogyakarta, Daerah Istimewa Yogyakarta 55224
                </p>
            </div>
            
            <!-- Google Maps Button -->
             <div class="mt-6 lg:mt-0">
                <a href="https://www.google.com/maps/search/?api=1&query=Butterly+Bites+Kotabaru+Yogyakarta" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="flex items-center gap-3 bg-white border border-gray-300 rounded px-4 py-2 hover:bg-gray-50 transition-colors shadow-sm group">
                    <img src="https://www.google.com/images/branding/product/1x/maps_64dp.png" alt="Google Maps" class="w-6 h-6 group-hover:scale-110 transition-transform">
                    <span class="font-sans text-brandBrown font-medium">Google Maps</span>
                </a>
            </div>
        </div>

        <!-- Links Section -->
        <div class="flex flex-col gap-3 mb-16">
            <!-- Row 1 -->
            <div class="flex flex-wrap gap-x-6 text-base font-sans font-medium text-textMain underline-offset-4 decoration-1">
                <a href="{{ route('dashboard') }}" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">My Account</a>
                <a href="#" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">Payment Confirmation</a>
                <a href="#" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">Shipping Information</a>
                <a href="{{ route('order.tracking') }}" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">Track Order</a>
            </div>
            <!-- Row 2 -->
             <div class="flex flex-wrap gap-x-6 text-base font-sans font-medium text-textMain underline-offset-4 decoration-1">
                <a href="{{ route('faq') }}" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">FAQ</a>
                <a href="#" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">Return Policy</a>
                <a href="#" class="hover:underline hover:text-brandRed transition-colors border-b border-textMain pb-0.5 leading-none">Conditions of Use</a>
            </div>
        </div>

        <!-- Bottom Section: Socials & Copyright -->
        <div class="flex flex-col lg:flex-row justify-between items-end gap-8">
            <!-- Socials -->
            <div>
                <h4 class="font-sans font-medium text-textMain mb-4 text-base border-b border-textMain inline-block pb-0.5 leading-none">Follow our Socials</h4>
                <div class="flex gap-4 items-center">
                    <!-- TikTok -->
                    <a href="#" class="text-textMain hover:text-brandRed transition-transform hover:scale-110">
                        <svg class="w-9 h-9 bg-[#2b201a] text-brandCream p-1.5 rounded-lg" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"></path>
                        </svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#" class="text-textMain hover:text-brandRed transition-transform hover:scale-110">
                         <svg class="w-9 h-9 border-2 border-[#2b201a] text-[#2b201a] p-1.5 rounded-lg" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"></path>
                        </svg>
                    </a>
                    <!-- Shopee -->
                     <a href="#" class="text-textMain hover:text-brandRed transition-transform hover:scale-110 bg-[#2b201a] text-brandCream p-1.5 rounded-lg flex items-center justify-center w-9 h-9">
                        <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="font-serif italic text-lg text-textMain/80 mb-1 lg:mb-0">
                Copyright 2026 Maneé
            </div>
        </div>
    </div>
</footer>
