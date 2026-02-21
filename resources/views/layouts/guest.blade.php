<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        /* Custom scrollbar to match dark theme */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #101622;
        }

        ::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }

        .bg-primary {
            background-color: #135bec;
        }

        .text-primary {
            color: #135bec;
        }

        .border-primary {
            border-color: #135bec;
        }

        .focus\:ring-primary:focus {
            --tw-ring-color: #135bec;
        }

        .hover\:bg-primary\/90:hover {
            background-color: rgb(19 91 236 / 0.9);
        }

        .bg-background-dark {
            background-color: #101622;
        }
    </style>
</head>

<body
    class="font-display antialiased bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex flex-col p-0 m-0 overflow-x-hidden selection:bg-primary/30 selection:text-primary">
    @hasSection('full-layout')
        @yield('full-layout')
    @else
        <div class="flex w-full min-h-screen lg:h-screen lg:overflow-hidden bg-background-light dark:bg-background-dark">
            <!-- Left Side: Hero Section -->
            <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between p-12 overflow-hidden bg-slate-900">
                <!-- Background Image with Overlay -->
                <div class="absolute inset-0 z-0">
                    <div class="w-full h-full bg-cover bg-center opacity-60"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAkS90O2Jfkdget9D-cyXTja9MX6dPBPLxz1NdT4cS3d2T4mfRWzXBD3ylc4crxniogC3edWm_nNw746sxSa4dmR-UCAeLuxeJS6jY0UTN1CX1YtwTQ59BIT0BRqgWwEEw-JtW8b2gtLzeh7Vgr_QfORlMplA719MGE1FLY5yxf0wxUYRLT3bg93qECmOOMXWLkfd8HXb5h4JvwQuVTjY2sagp2eObb3S9bSb0wR9RzWnwVYQgf-0R9-zpe_jkVfrrut7804zALZks");'>
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#101622] via-[#135bec]/20 to-transparent"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <!-- Logo Area -->
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin" class="h-10 w-10 rounded-lg" />
                        <span class="text-2xl font-bold tracking-tight text-white">DIJADIIN</span>
                    </div>

                    <!-- Hero Text -->
                    <div class="max-w-md">
                        <h1 class="text-4xl font-bold text-white mb-4 leading-tight">
                            Turn ideas into reality<br />with AI power.
                        </h1>
                        <p class="text-lg text-slate-300 font-medium">
                            "Tulis Ide, Jadiin Aplikasi"
                        </p>
                        <div class="mt-8 flex gap-2">
                            <div class="h-1 w-8 rounded-full bg-primary"></div>
                            <div class="h-1 w-2 rounded-full bg-slate-600"></div>
                            <div class="h-1 w-2 rounded-full bg-slate-600"></div>
                        </div>
                    </div>

                    <!-- Footer Text -->
                    <div class="text-sm text-slate-400">
                        © {{ date('Y') }} Tim Poliwindra. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- Right Side: Content Area -->
            <div
                class="flex w-full lg:w-1/2 flex-col justify-center items-center bg-background-light dark:bg-background-dark py-8 px-4 sm:px-6 lg:px-20 lg:overflow-y-auto">
                <div class="w-full max-w-[420px] flex flex-col gap-5">
                    <!-- Mobile Logo (Visible only on small screens) -->
                    <div class="lg:hidden flex items-center gap-2 mb-4 self-center">
                        <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin" class="h-8 w-8 rounded" />
                        <span class="text-xl font-bold tracking-tight dark:text-white">DIJADIIN</span>
                    </div>

                    <!-- Form Content from Views -->
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </div>
        </div>
    @endif
</body>

</html>