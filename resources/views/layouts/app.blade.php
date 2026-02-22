<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Di-Jadiin - Tim Poliwindra') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="sidebarLayout()" class="min-h-screen bg-gray-100 dark:bg-[#0f1115] flex flex-col sm:flex-row w-full">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            <!-- Page Heading -->
            @if (isset($header) || View::hasSection('header'))
                <header class="bg-white dark:bg-[#161b22] shadow dark:shadow-none dark:border-b dark:border-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header ?? '' }}
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>

        @include('auth.logout-modal')
    </div>

    <script>
        function sidebarLayout() {
            return {
                sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
                showLogoutModal: false,
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    localStorage.setItem('sidebarOpen', this.sidebarOpen);
                }
            }
        }
    </script>
</body>

</html>
