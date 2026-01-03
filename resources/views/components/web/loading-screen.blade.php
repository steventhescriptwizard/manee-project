<div class="fixed inset-0 z-[100] flex min-h-screen w-full flex-col overflow-hidden items-center justify-center bg-backgroundLight transition-opacity duration-500 max-h-screen"
     x-show="isLoading"
     x-transition:leave="opacity-0 pointer-events-none">
    
    <!-- Main Content Container -->
    <div class="flex flex-col items-center justify-center max-w-[960px] w-full px-6 z-10">
        <!-- Logo Section -->
        <div class="animate-pulse-slow flex flex-col items-center">
            <h1 class="font-serif-brand text-manee-text text-6xl md:text-8xl font-bold tracking-normal leading-tight text-center pb-2 select-none">
                Maneé
            </h1>
        </div>
        
        <!-- Loading Indicator: Animated Dots -->
        <div class="flex gap-3 py-8 items-center justify-center h-12">
            <div class="w-2.5 h-2.5 rounded-full bg-primary animate-bounce" style="animation-delay: 0ms"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-primary animate-bounce" style="animation-delay: 150ms"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-primary animate-bounce" style="animation-delay: 300ms"></div>
        </div>

        <!-- Tagline -->
        <div class="opacity-0 animate-fade-in-up" style="animation-delay: 500ms">
            <p class="font-sans-brand text-manee-subtext text-sm md:text-base font-light tracking-[0.25em] uppercase text-center">
                Classic. Stylish. You.
            </p>
        </div>
    </div>

    <!-- Subtle Background Decor -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-[#bed3f9]/20 via-transparent to-transparent"></div>
</div>
