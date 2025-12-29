<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Maneé Admin')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-slate-900 dark:bg-gray-900 dark:text-white antialiased">
    <div 
        x-data="{ 
            sidebarOpen: false, 
            userDropdownOpen: false 
        }" 
        class="flex h-screen w-full font-sans overflow-hidden"
    >
        <!-- Sidebar -->
        @include('components.admin.sidebar')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50 dark:bg-gray-900 relative">
            @include('components.admin.header')

            <div class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 scroll-smooth">
                @yield('content')
            </div>
        </main>
    </div>
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

        // Global Error Alert (for non-login pages or generic errors)
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
        
        // Delete Confirmation
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.delete-btn')) {
                e.preventDefault();
                const form = e.target.closest('form');
                
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete!",
                    width: '260px',
                    padding: '10px',
                    customClass: {
                        popup: 'rounded-xl text-xs',
                        title: 'text-sm font-bold',
                        content: 'text-xs',
                        actions: 'gap-2',
                        confirmButton: 'bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg',
                        cancelButton: 'bg-slate-200 text-slate-700 text-xs px-3 py-1.5 rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });

        // Save Confirmation (for forms with class 'confirm-save')
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.classList.contains('confirm-save')) {
                e.preventDefault();
                const form = e.target;

                Swal.fire({
                    title: "Do you want to save the changes?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    denyButtonText: `No`,
                    width: '260px',
                    padding: '10px',
                    customClass: {
                        popup: 'rounded-xl text-xs',
                        title: 'text-sm font-bold',
                        actions: 'gap-2',
                        confirmButton: 'bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg',
                        denyButton: 'bg-slate-200 text-slate-700 text-xs px-3 py-1.5 rounded-lg',
                        cancelButton: 'hidden'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        // Optional: Show immediate success before reload (server will redirect with success message usually)
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
            }
        });

        // Logout Alert
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
                   // Always submit even if timer closes it, or specifically on close
                   if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                        form.submit();
                   }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
