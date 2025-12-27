@extends('layouts.web')

@section('title', 'About Us - Maneé Fashion Store')

@section('content')
<div class="relative flex min-h-screen flex-col font-body text-[#111318] bg-white">
    
    <!-- Hero Section -->
    <section class="relative w-full py-24 md:py-32 lg:py-40 overflow-hidden mt-16 md:mt-0">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/70 to-transparent z-10"></div>
            <div class="w-full h-full bg-cover bg-center bg-no-repeat" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBcRjMDelbgWMP5NcsEXzQhspefFRilaKWxLHflw52-LbyVQfAEEQKiWg3GweE-GkVocipCbPiZ1zr_nqhxMCKqCmE_5l0gBr941u1uNb_8gkDYwwQoS8jJuPpCBz2wvKalzBazA9x1WATG6FpCoDAw428ALjCJswGcUkm9QU-y7IMT6Fm1LVY8JwZ5yRedoRLHlbTsVmKNWNXx_yB1lePpaGmPPg2hAb8yjPvWSO9Q8DmGFDokj--_jYbuxAzjEmVjUXvxQeTbl6w");'>
            </div>
        </div>
        <div class="relative z-20 mx-auto max-w-7xl px-6">
            <div class="max-w-2xl animate-fade-in-up">
                <span class="mb-4 inline-block rounded-full bg-brandLightBlue/20 px-4 py-1.5 text-xs font-bold text-brandBlue tracking-widest uppercase">
                    Since 2023
                </span>
                <h1 class="mb-6 font-display text-5xl font-bold leading-tight tracking-tight text-[#111318] md:text-6xl lg:text-7xl">
                    Our Story.
                </h1>
                <p class="mb-8 font-body text-lg leading-relaxed text-gray-600 md:text-xl">
                    Effortless style for the modern Indonesian woman. We believe fashion should be versatile, affordable, and undeniably chic.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission / Narrative Block (Strictly Light) -->
    <section class="py-16 md:py-24 bg-white">
        <div class="mx-auto max-w-3xl px-6 text-center">
            <span class="material-symbols-outlined text-4xl text-brandLightBlue mb-6">spa</span>
            <h2 class="mb-8 font-display text-3xl font-semibold leading-snug text-[#111318] md:text-4xl">
                "Maneé is designed for the everyday lives of women aged 20-40. We bridge the gap between minimalist aesthetics and classic charm."
            </h2>
            <p class="font-body text-base leading-relaxed text-gray-600">
                Founded with a simple mission: to offer affordable, stylish, and easy-to-wear pieces that don't compromise on quality. In a world of fast fashion, we strive to create collections that feel personal and permanent. Our pieces are meant to be worn, loved, and lived in—from the office to the weekend getaway.
            </p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="bg-[#f8f9fa] py-20">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-8 md:grid-cols-3">
                <!-- Card 1 -->
                <div class="group relative overflow-hidden rounded-xl bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md border border-gray-100">
                    <div class="mb-6 inline-flex size-14 items-center justify-center rounded-lg bg-brandLightBlue/10 text-brandLightBlue">
                        <span class="material-symbols-outlined text-3xl">checkroom</span>
                    </div>
                    <h3 class="mb-3 font-display text-2xl font-bold text-[#111318]">Self-Manufactured</h3>
                    <p class="font-body text-gray-600">
                        We control every step of our production line. This allows us to ensure the highest quality fabrics and ethical stitching while keeping costs accessible for you.
                    </p>
                </div>
                <!-- Card 2 -->
                <div class="group relative overflow-hidden rounded-xl bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md border border-gray-100">
                    <div class="mb-6 inline-flex size-14 items-center justify-center rounded-lg bg-brandLightBlue/10 text-brandLightBlue">
                        <span class="material-symbols-outlined text-3xl">all_inclusive</span>
                    </div>
                    <h3 class="mb-3 font-display text-2xl font-bold text-[#111318]">Timeless Style</h3>
                    <p class="font-body text-gray-600">
                        Trends fade, but style remains. Our silhouettes are designed to be classic staples in your wardrobe that you can mix and match for years to come.
                    </p>
                </div>
                <!-- Card 3 -->
                <div class="group relative overflow-hidden rounded-xl bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md border border-gray-100">
                    <div class="mb-6 inline-flex size-14 items-center justify-center rounded-lg bg-brandLightBlue/10 text-brandLightBlue">
                        <span class="material-symbols-outlined text-3xl">favorite</span>
                    </div>
                    <h3 class="mb-3 font-display text-2xl font-bold text-[#111318]">Made for You</h3>
                    <p class="font-body text-gray-600">
                        Understanding the modern Indonesian woman's body and lifestyle is at our core. Versatile cuts that flatter and fabrics that breathe in our tropical climate.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Split Section: The Process -->
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div class="relative order-2 lg:order-1">
                    <div class="aspect-[4/5] w-full overflow-hidden rounded-2xl">
                        <div class="h-full w-full bg-cover bg-center transition-transform duration-700 hover:scale-105" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD0WQJNmYsQeJWpgYAwVnIWAlr8NRtrZOqEGdqDVvij_-erFZt4Z9TfsJ9fnT2Hwxb-sElocf7Jr5suFpQApNLJnWJLX77xJc7airsM8rcj37H7Z2vEHJSSzbHBDSBYAZBIWILClXAiSts7lHfglLwITjZB7QRGPd_44O4VEGLoplAYUGcvDnWn_J7noHEz7HUZTjPCIlXGVq_jHAh2DqnuLqfaHaYzyzvJ0GPw_eqCgaSLvN8oE0Lj21UKXxKKnPe1X5jOQ_GzK1w");'>
                        </div>
                    </div>
                    <!-- Decorative floating card -->
                    <div class="absolute -bottom-6 -right-6 hidden md:block rounded-lg bg-white p-6 shadow-xl max-w-xs border border-gray-100">
                        <p class="font-display text-xl font-medium italic text-gray-800">"Attention to detail is the definition of quality."</p>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="mb-6 font-display text-4xl font-bold text-[#111318] lg:text-5xl">The Production Process</h2>
                    <div class="space-y-6 font-body text-lg text-gray-600">
                        <p>
                            Being <strong class="text-[#111318] font-medium">self-manufactured</strong> is our superpower. It allows us to adapt quickly to emerging trends while maintaining strict quality control that mass-market brands often miss.
                        </p>
                        <p>
                            From hand-picking the softest linens and cottons to the final stitch, every piece is crafted with care in our local workshop. We take pride in creating garments that feel as good as they look.
                        </p>
                        <div class="pt-4">
                            <a href="#" class="inline-flex h-12 items-center justify-center rounded-lg bg-brandLightBlue px-8 text-base font-bold text-[#111318] transition-all hover:bg-blue-200">
                                View Collections
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team / Visual Break -->
    <section class="relative w-full py-20 bg-gray-50/50">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex flex-col items-center justify-center gap-10 lg:flex-row">
                <div class="flex-1 space-y-4 text-center lg:text-left">
                    <h2 class="font-display text-3xl font-bold text-[#111318] lg:text-4xl">Meet the Makers</h2>
                    <p class="font-body text-gray-600 max-w-md mx-auto lg:mx-0">
                        Behind every stitch is a dedicated team of passionate individuals working to bring Maneé to life.
                    </p>
                </div>
                <div class="flex flex-1 justify-center gap-4">
                    <div class="h-64 w-48 overflow-hidden rounded-lg bg-gray-200">
                        <div class="h-full w-full bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCcxlwvA8ysef14nKh5KzMrRoy33ojviIe9xErGeocF17NGmfNXe_oYlqVpqtcMgTYGnsPcDW5G3Ab5pqmUs7mJ23KUX1pKHCrOmU32nVodPPdkymebioWvdjPb9ksoq3N0oGSQ9nrlKgE7uwTeBBl_J2yq1GXHIXBn1wKwOPLaUI8-fcFNKL7dM746QngAXgGsPqPkyFBPqK0SF9-hYBmiA9XBBxSefBRPcdbq5klXCO8hKWqei90Fl0fHd9oEgu-SjAEGdmUiojM");'></div>
                    </div>
                    <div class="mt-8 h-64 w-48 overflow-hidden rounded-lg bg-gray-200">
                        <div class="h-full w-full bg-cover bg-center" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAVM7BDsEcREkc-y-L5SqkizvQ62FBQdsXIXEW9XA5IBLORitiospcZiHhCOFMTTQUvEQhpvJMUJBzojuGsPL3MQFA_8_WE2L6Csam9J-GsBbQfGUDNs-6G4P_udC7wi0h00yge29wqd0QawDythi_8fPzVa9BLbajaIQYBOxJbrsWzDhiF2IDRWOgL7K8sFYoxh3oFcy5xJi_-KelhQGl8qScf7qouCwlltCGkttDrftKLN3MpSfGjLUnE5RgewUF0VfWPawgBQbo");'></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-24 bg-white">
        <div class="mx-auto max-w-4xl px-6 text-center">
            <div class="rounded-3xl bg-gray-50 px-6 py-16 md:px-12 border border-gray-100">
                <h2 class="mb-4 font-display text-3xl font-bold text-[#111318] md:text-4xl">Join the Maneé Community</h2>
                <p class="mb-8 font-body text-gray-600">
                    Be the first to know about new arrivals, exclusive sales, and stories from our studio.
                </p>
                <form class="mx-auto flex max-w-md flex-col gap-3 sm:flex-row">
                    <input class="h-12 w-full flex-1 rounded-lg border border-gray-200 bg-white px-4 text-sm outline-none focus:border-brandBlue focus:ring-2 focus:ring-brandBlue/20" placeholder="Enter your email" required="" type="email"/>
                    <button class="h-12 w-full rounded-lg bg-[#111318] px-6 font-bold text-white transition-opacity hover:opacity-90 sm:w-auto" type="submit">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
