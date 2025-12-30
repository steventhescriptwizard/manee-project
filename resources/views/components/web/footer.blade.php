<footer class="bg-brandCream border-t border-gray-200 pt-16 pb-10">
    <div class="container mx-auto px-6 lg:px-10 relative overflow-hidden">
        <!-- Logo Background Watermark -->
        <div class="absolute right-12 bottom-14 opacity-[0.90] pointer-events-none select-none lg:block hidden z-0">
            <img src="{{ asset('images/Manee M Footer.svg') }}" alt="Manee Logo" class="w-[500px] h-auto">
        </div>

        <div class="flex flex-col lg:flex-row justify-between gap-12 mb-12 relative z-10">
            <div class="lg:w-2/3 flex flex-col gap-10">
                <div>
                    <h4 class="font-sans font-medium text-textMain mb-3 text-lg">Visit Our Store</h4>
                    <p class="font-sans text-gray-600 font-light leading-relaxed max-w-md text-sm">
                        Jl. Sareh No.5, Kotabaru, Kec. Gondokusuman,<br />
                        Kota Yogyakarta, Daerah Istimewa Yogyakarta 55224
                    </p>
                </div>
                <div>
                    <h4 class="font-sans font-medium text-textMain mb-4 text-lg">Useful Links</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-3 max-w-2xl text-sm font-sans text-gray-600">
                        <a href="#" class="hover:text-brandRed transition-colors">My Account</a>
                        <a href="#" class="hover:text-brandRed transition-colors">Payment Confirmation</a>
                        <a href="#" class="hover:text-brandRed transition-colors">Shipping Information</a>
                        <a href="{{ route('order.tracking') }}" class="hover:text-brandRed transition-colors">Track Order</a>
                        <a href="{{ route('faq') }}" class="hover:text-brandRed transition-colors">FAQ</a>
                        <a href="#" class="hover:text-brandRed transition-colors">Return Policy</a>
                        <a href="{{ route('about') }}" class="hover:text-brandRed transition-colors">About Us</a>
                        <a href="#" class="hover:text-brandRed transition-colors">Conditions of Use</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-sans font-medium text-textMain mb-4 text-lg">Follow Us</h4>
                    <div class="flex gap-5 items-center">
                        <a href="#" class="text-textMain hover:text-brandRed transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-textMain hover:text-brandRed transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-textMain hover:text-brandRed transition-colors">
                            <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 flex lg:justify-end items-start">
                <a href="https://www.google.com/maps/search/?api=1&query=Butterly+Bites+Kotabaru+Yogyakarta" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="flex items-center gap-2 border border-gray-300 rounded px-5 py-2.5 hover:bg-gray-50 transition-colors text-textMain bg-white shadow-sm">
                    <span class="material-symbols-outlined text-red-700 text-xl">location_on</span>
                    <span class="font-sans text-sm font-medium">Open in Google Maps</span>
                </a>
            </div>
        </div>
        <div class="border-t border-gray-200 pt-8 font-serif italic text-lg text-gray-400 text-center lg:text-center z-10 flex items-center justify-center gap-2">
            Copyright 2026 <img src="{{ asset('images/Manee Logo_Main.svg') }}" alt="Maneé Logo" class="h-6 w-auto opacity-50 grayscale hover:grayscale-0 transition-all">
        </div>
    </div>
</footer>
