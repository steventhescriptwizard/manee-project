<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Maneé Fashion Store')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/Manee M Footer.svg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Cormorant+Infant:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Rubik:ital,wght@0,300..900;1,300..900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-white">
    
    @include('components.web.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.web.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Global Success Toast
        @if(session('success'))
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500,
            width: '260px',
            padding: '10px',
            customClass: {
                popup: 'rounded-xl text-xs',
                title: 'text-sm font-bold',
                icon: 'text-xs'
            }
        });
        @endif

        // Global Error Alert
        @if(session('error'))
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "{{ session('error') }}",
            width: '260px',
            padding: '10px',
            customClass: {
                popup: 'rounded-xl text-xs',
                title: 'text-sm font-bold',
                content: 'text-xs',
                confirmButton: 'text-xs px-3 py-1.5'
            }
        });
        @endif

        // Logout Alert for Web
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.logout-btn')) {
                e.preventDefault();
                const form = e.target.closest('form');
                let timerInterval;

                Swal.fire({
                    title: "Auto close alert!",
                    html: "I will close in <b></b> milliseconds.",
                    timer: 2000,
                    timerProgressBar: true,
                    width: '260px',
                    padding: '10px',
                    customClass: {
                        popup: 'rounded-xl text-xs',
                        title: 'text-sm font-bold',
                        content: 'text-xs'
                    },
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                   if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                        form.submit();
                   }
                });
            }
        });
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('scripts')
</body>
</html>
