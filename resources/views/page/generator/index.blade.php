<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('AI Builder Project Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 transition-all duration-300">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h3
                            class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-600">
                            Scaffold New Laravel Project</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Set up a fresh installation tailored to your
                            specific database environment.</p>
                    </div>

                    <form id="generator-form" action="{{ route('project.generator.store') }}" method="POST"
                        class="space-y-6">
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-50 dark:bg-red-900/50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors
                                            with your submission</h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Project Details -->
                            <div
                                class="space-y-6 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                <h4 class="font-semibold text-lg text-indigo-500 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    Project Details
                                </h4>

                                <div>
                                    <label for="project_name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project
                                        Name</label>
                                    <input type="text" name="project_name" id="project_name" required
                                        placeholder="e.g. ecommerce-app"
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors">
                                    <p class="mt-1 text-xs text-gray-500">Only alphanumeric, dashes, and underscores
                                        allowed.</p>
                                </div>

                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        placeholder="Brief explanation of the project..."
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors"></textarea>
                                </div>
                            </div>

                            <!-- Database Configuration -->
                            <div
                                class="space-y-6 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                <h4 class="font-semibold text-lg text-purple-500 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                                        </path>
                                    </svg>
                                    Database Config
                                </h4>

                                <div>
                                    <label for="db_type"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Database
                                        Connection Type</label>
                                    <select name="db_type" id="db_type" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        <option value="mysql">MySQL</option>
                                        <option value="pgsql">PostgreSQL</option>
                                        <option value="sqlite">SQLite</option>
                                    </select>
                                </div>

                                <div id="db-credentials" class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="db_name"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Database
                                                Name</label>
                                            <input type="text" name="db_name" id="db_name" placeholder="e.g. laravel_db"
                                                required
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                        <div>
                                            <label for="db_port"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Database
                                                Port</label>
                                            <input type="text" name="db_port" id="db_port" placeholder="e.g. 3306"
                                                value="3306"
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="db_username"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                                            <input type="text" name="db_username" id="db_username" value="root"
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                        <div>
                                            <label for="db_password"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                            <input type="password" name="db_password" id="db_password"
                                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm transition-colors">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AI Context Area -->
                        <div
                            class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                            <h4 class="font-semibold text-lg text-emerald-500 flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                AI Context Prompt (Gemini Builder)
                            </h4>
                            <div>
                                <label for="ai_prompt"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tell Gemini
                                    what you want this project to be <span class="text-red-500">*</span></label>
                                <textarea name="ai_prompt" id="ai_prompt" rows="4" required
                                    placeholder="e.g. I want to build a pos application with a dashboard for admin and pos for user..."
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-colors"></textarea>
                                <p class="mt-2 text-xs text-gray-500">The context prompt and gemini token will be
                                    automatically injected into your generated .env file.</p>
                            </div>
                        </div>

                        <!-- Submit Area -->
                        <div
                            class="flex items-center justify-end pt-4 border-t border-gray-200 dark:border-gray-700 mt-6 pt-6">
                            <button type="submit" id="submit-btn"
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                                <span id="btn-text">Generate Project</span>
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Loading State (Hidden initially) -->
                    <div id="loading-state"
                        class="hidden fixed inset-0 z-[100] bg-[#101423] text-white flex-col items-center justify-center min-h-screen"
                        style="background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px;">
                        <!-- Header Logo -->
                        <div class="absolute top-6 left-8 flex items-center gap-3">
                            <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin"
                                class="h-8 w-auto filter drop-shadow-[0_0_8px_rgba(59,130,246,0.3)]" />
                            <span class="font-bold text-lg tracking-wider text-white">DIJADIIN</span>
                        </div>

                        <div
                            class="max-w-[1200px] w-full mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center h-full pt-10 pb-6 overflow-y-auto">

                            <!-- Left Section (Copy & Illustration) -->
                            <div class="space-y-4">
                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-900/30 border border-blue-500/20 text-blue-300 text-sm font-medium shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                                    <span
                                        class="w-2 h-2 rounded-full bg-blue-400 animate-pulse shadow-[0_0_8px_rgba(96,165,250,0.8)]"></span>
                                    Sedang Berlangsung
                                </div>
                                <h2 class="text-3xl lg:text-4xl font-extrabold leading-[1.1] text-white tracking-tight">
                                    Meracik Aplikasi<br>Impianmu
                                </h2>
                                <p class="text-base text-[#94a3b8] max-w-md leading-relaxed font-light">
                                    Duduk santai ya! AI Arsitek kami sedang sibuk menyusun kode terbaik agar idemu
                                    segera hidup.
                                </p>

                                <!-- Illustration Box -->
                                <div
                                    class="relative w-full max-w-[420px] aspect-[16/10] mt-5 rounded-2xl border border-gray-800/60 bg-[#161c2d]/70 overflow-hidden shadow-2xl backdrop-blur-sm bg-[linear-gradient(to_right,rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:2rem_2rem]">
                                    <!-- Animated elements inside box -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div
                                            class="relative flex flex-col items-center justify-center animate-bounce duration-[3000ms]">
                                            <div
                                                class="bg-[#e2e8f0] rounded-2xl p-4 shadow-[0_0_30px_rgba(255,255,255,0.1)] flex items-center justify-center gap-4 relative z-10 w-48 h-28 mb-2 border-b-4 border-gray-300">
                                                <div
                                                    class="bg-[#1e293b] rounded-xl w-14 h-14 flex items-center justify-center shadow-inner">
                                                    <div class="w-2.5 h-6 bg-blue-400 rounded-sm mx-1 animate-pulse">
                                                    </div>
                                                    <div
                                                        class="w-2.5 h-6 bg-blue-400 rounded-sm mx-1 animate-pulse delay-75">
                                                    </div>
                                                </div>
                                                <div
                                                    class="absolute -right-6 -top-5 bg-blue-500 rounded-xl p-3 shadow-[0_0_25px_rgba(59,130,246,0.6)]">
                                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- Bottom Base Component -->
                                            <div
                                                class="bg-gray-300 w-32 h-14 rounded-b-xl shadow-inner flex items-center justify-center -mt-4 z-0 relative overflow-hidden flex-col gap-1">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shadow mt-3">
                                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- Server Racks Behind Elements -->
                                            <div
                                                class="absolute -bottom-24 z-[-1] flex gap-4 w-64 items-end justify-center">
                                                <div
                                                    class="w-12 h-20 bg-gradient-to-t from-blue-500/20 to-transparent border border-blue-500/30 rounded-t-lg">
                                                </div>
                                                <div
                                                    class="w-16 h-32 bg-gradient-to-t from-blue-500/30 to-transparent border border-blue-500/40 rounded-t-lg shadow-[0_0_20px_rgba(59,130,246,0.2)]">
                                                </div>
                                                <div
                                                    class="w-12 h-16 bg-gradient-to-t from-blue-500/10 to-transparent border border-gray-600/30 rounded-t-lg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Decorative gradients -->
                                    <div class="absolute bottom-0 left-1/4 w-32 h-32 bg-blue-500/20 blur-[50px]"></div>
                                    <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-purple-500/10 blur-[50px]">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Section (Status & Steps) -->
                            <div class="space-y-4 w-full max-w-md mx-auto lg:ml-auto select-none">
                                <!-- Status Card -->
                                <div
                                    class="bg-[#151a2b] border border-[#2a3143] rounded-2xl p-5 relative overflow-hidden shadow-2xl">
                                    <div class="absolute -right-4 -bottom-4 text-[100px] font-black italic text-white/[0.04] pointer-events-none tracking-tighter"
                                        id="bg-progress-text">0%</div>

                                    <div class="flex justify-between items-end mb-4 relative z-10">
                                        <h4 class="text-[11px] font-bold text-gray-400 tracking-wider">STATUS
                                            PEMBANGUNAN</h4>
                                        <span class="text-4xl font-extrabold text-white"
                                            id="progress-percentage">0%</span>
                                    </div>

                                    <div class="w-full bg-[#1e2538] rounded-full h-2.5 mb-5 relative z-10">
                                        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 h-2.5 rounded-full transition-all duration-300 shadow-[0_0_12px_rgba(56,189,248,0.6)]"
                                            id="progress-bar" style="width: 0%"></div>
                                        <div class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,0.9)] transition-all duration-300"
                                            id="progress-knob" style="left: 0%"></div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 relative z-10">
                                        <div class="bg-[#1a2035] rounded-xl p-3 flex flex-col justify-center">
                                            <p
                                                class="text-[9px] text-gray-500 uppercase tracking-widest font-semibold mb-1">
                                                WAKTU BERJALAN</p>
                                            <p class="text-xl sm:text-2xl font-semibold text-white tracking-tight"
                                                id="timer-display">00:00 <span
                                                    class="text-sm text-gray-500 font-sans">mnt</span></p>
                                        </div>
                                        <div class="bg-[#1a2035] rounded-xl p-3 flex flex-col justify-center">
                                            <p
                                                class="text-[9px] text-gray-500 uppercase tracking-widest font-semibold mb-1">
                                                ESTIMASI SELESAI</p>
                                            <p class="text-xl sm:text-2xl font-semibold text-blue-400 tracking-tight">
                                                ~45 <span class="text-sm text-gray-500 font-sans">dtk</span></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tasks Card -->
                                <div
                                    class="bg-[#151a2b] border border-[#2a3143] rounded-2xl overflow-hidden shadow-2xl">
                                    <div class="p-4 border-b border-[#2a3143] flex items-center gap-3">
                                        <div
                                            class="w-6 h-6 rounded-full bg-yellow-400/20 flex items-center justify-center text-yellow-400 text-xs shadow-inner">
                                            💡</div>
                                        <h4 class="text-sm font-bold text-white tracking-wide">Cerita Pembuatan</h4>
                                    </div>
                                    <div class="py-2 px-2">
                                        <div class="space-y-1 relative" id="steps-container">
                                            <!-- Step 1 -->
                                            <div class="step-item p-2.5 flex gap-3.5 items-start rounded-xl transition-all duration-300"
                                                id="step-1">
                                                <div
                                                    class="step-icon mt-1 w-6 h-6 rounded-full border border-gray-600 text-gray-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[13px] font-semibold text-gray-300 step-title">
                                                        Mencatat
                                                        ide hebatmu...</p>
                                                    <p class="text-[11px] text-gray-500 mt-1 step-desc">Semua detail
                                                        sudah
                                                        kami simpan dengan aman.</p>
                                                </div>
                                            </div>

                                            <!-- Step 2 -->
                                            <div class="step-item p-2.5 flex gap-3.5 items-start rounded-xl transition-all duration-300 opacity-50"
                                                id="step-2">
                                                <div
                                                    class="step-icon mt-1 w-6 h-6 rounded-full border border-gray-600 text-gray-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[13px] font-semibold text-gray-400 step-title">
                                                        Menyusun
                                                        fondasi aplikasi...</p>
                                                    <p class="text-[11px] text-gray-500 mt-1 step-desc">Struktur
                                                        database
                                                        sudah siap digunakan.</p>
                                                </div>
                                            </div>

                                            <!-- Step 3 -->
                                            <div class="step-item p-2.5 flex gap-3.5 items-start rounded-xl transition-all duration-300 opacity-50"
                                                id="step-3">
                                                <div
                                                    class="step-icon mt-1 w-6 h-6 rounded-full border border-gray-600 text-gray-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[13px] font-semibold text-gray-400 step-title">
                                                        Merapikan
                                                        kode agar cantik...</p>
                                                    <p class="text-[11px] text-gray-500 mt-1 step-desc">Sedang memoles
                                                        tampilan dan logika biar mulus.</p>
                                                </div>
                                            </div>

                                            <!-- Step 4 -->
                                            <div class="step-item p-2.5 flex gap-3.5 items-start rounded-xl transition-all duration-300 opacity-50"
                                                id="step-4">
                                                <div
                                                    class="step-icon mt-1 w-6 h-6 rounded-full border border-gray-500 text-gray-400 flex items-center justify-center shrink-0 border-dashed">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 5a1 1 0 012 0v4.293l2.707 2.707a1 1 0 01-1.414 1.414l-3-3A1 1 0 019 10V5z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[13px] font-regular text-gray-500 step-title">Siap
                                                        untuk
                                                        kamu coba!</p>
                                                    <p class="text-[11px] text-gray-600 mt-1 step-desc">Menunggu langkah
                                                        sebelumnya selesai.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center pt-1 pb-4">
                                    <button type="button" onclick="window.location.reload()"
                                        class="text-sm text-gray-400 hover:text-white transition-colors flex items-center justify-center gap-2 mx-auto">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Berubah pikiran? Batalkan
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!-- Footer text -->
                        <div class="absolute bottom-6 w-full text-center text-xs text-gray-500 font-light">
                            &copy; {{ date('Y') }} DIJADIIN AI. &bull; Dibuat dengan <span class="text-red-500">❤️</span> untuk
                            kreator.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- UI Logic Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('generator-form');
            const submitBtn = document.getElementById('submit-btn');
            const loadingState = document.getElementById('loading-state');
            const dbType = document.getElementById('db_type');
            const dbCredentials = document.getElementById('db-credentials');
            const dbPort = document.getElementById('db_port');

            // Hide credentials if SQLite
            dbType.addEventListener('change', (e) => {
                if (e.target.value === 'sqlite') {
                    dbCredentials.classList.add('opacity-50', 'pointer-events-none');
                } else {
                    dbCredentials.classList.remove('opacity-50', 'pointer-events-none');
                    if (e.target.value === 'pgsql') {
                        dbPort.value = '5432';
                    } else if (e.target.value === 'mysql') {
                        dbPort.value = '3306';
                    }
                }
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Show fullscreen loading
                loadingState.classList.remove('hidden');
                loadingState.classList.add('flex');

                // Optional: Prevent background scroll
                document.body.style.overflow = 'hidden';

                const formData = new FormData(form);
                const payload = {};
                formData.forEach((value, key) => { payload[key] = value });

                // UI Elements
                const progressBar = document.getElementById('progress-bar');
                const progressKnob = document.getElementById('progress-knob');
                const progressPercent = document.getElementById('progress-percentage');
                const bgProgressText = document.getElementById('bg-progress-text');
                const timerDisplay = document.getElementById('timer-display');

                let progress = 0;
                let startTime = Date.now();
                let timerInterval;

                const checkIcon = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>';
                const loadingIcon = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                // Steps UI Status Logic
                function updateStep(stepNum, status) {
                    const stepEl = document.getElementById('step-' + stepNum);
                    if (!stepEl) return;

                    const iconBox = stepEl.querySelector('.step-icon');
                    const title = stepEl.querySelector('.step-title');
                    const desc = stepEl.querySelector('.step-desc');

                    if (status === 'active') {
                        stepEl.classList.remove('opacity-50');
                        stepEl.classList.add('bg-blue-600/10');
                        iconBox.className = "step-icon mt-1 w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0 mb-auto shadow-[0_0_10px_rgba(59,130,246,0.3)]";
                        iconBox.innerHTML = loadingIcon;
                        title.classList.remove('text-gray-400', 'text-gray-300', 'font-regular');
                        title.classList.add('text-white', 'font-bold');
                        desc.classList.remove('text-gray-600');
                        desc.classList.add('text-blue-200/70');
                    } else if (status === 'done') {
                        stepEl.classList.remove('opacity-50', 'bg-blue-600/10');
                        iconBox.className = "step-icon mt-1 w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mb-auto";
                        iconBox.innerHTML = checkIcon;
                        title.classList.remove('text-white', 'font-bold');
                        title.classList.add('text-gray-300', 'font-semibold');
                        desc.classList.add('text-gray-500');
                        desc.classList.remove('text-blue-200/70');
                    }
                }

                function setProgress(val) {
                    progress = val;
                    if (progress > 100) progress = 100;
                    const displayProgress = Math.floor(progress) + '%';
                    progressBar.style.width = displayProgress;
                    progressKnob.style.left = displayProgress;
                    progressPercent.textContent = displayProgress;
                    bgProgressText.textContent = displayProgress;

                    // Simple interval logic to map progress percentage to steps automatically
                    if (progress < 10) {
                        updateStep(1, 'active');
                    } else if (progress >= 10 && progress < 45) {
                        updateStep(1, 'done');
                        updateStep(2, 'active');
                    } else if (progress >= 45 && progress < 85) {
                        updateStep(2, 'done');
                        updateStep(3, 'active');
                    } else if (progress >= 85 && progress < 100) {
                        updateStep(3, 'done');
                        updateStep(4, 'active');
                    } else if (progress >= 100) {
                        updateStep(4, 'done');
                    }
                }

                // Initial setup
                setProgress(2);
                let fakeProgressInterval = setInterval(() => {
                    if (progress < 90) { // cap fake progress to 90% naturally
                        setProgress(progress + (Math.random() * 1.5));
                    }
                }, 1500);

                // Start Timer Loop
                timerInterval = setInterval(() => {
                    const ms = Date.now() - startTime;
                    const totalSec = Math.floor(ms / 1000);
                    const min = String(Math.floor(totalSec / 60)).padStart(2, '0');
                    const sec = String(totalSec % 60).padStart(2, '0');
                    timerDisplay.innerHTML = `${min}:${sec} <span class="text-sm text-gray-500 font-sans">mnt</span>`;
                }, 1000);

                // Start Server Request
                const queryParam = encodeURIComponent(JSON.stringify(payload));
                const evtSource = new EventSource(`{{ route('project.generator.stream') }}?payload=${queryParam}`);

                evtSource.onmessage = function (event) {
                    const data = JSON.parse(event.data);

                    if (data.type === 'log') {
                        // Boost progress naturally upon receiving real logs
                        if (progress < 90 && Math.random() > 0.5) setProgress(progress + 0.8);
                    } else if (data.type === 'error') {
                        evtSource.close();
                        clearInterval(fakeProgressInterval);
                        clearInterval(timerInterval);
                        alert("Gagal membangun aplikasi: " + data.message);
                        window.location.reload();
                    } else if (data.type === 'done') {
                        evtSource.close();
                        clearInterval(fakeProgressInterval);
                        clearInterval(timerInterval);
                        setProgress(100);

                        setTimeout(() => {
                            window.location.href = `/ai-builder/explorer/${data.message}`;
                        }, 1200);
                    }
                };

                evtSource.onerror = function (err) {
                    console.error("EventSource failed:", err);
                    evtSource.close();
                    clearInterval(fakeProgressInterval);
                    clearInterval(timerInterval);
                };
            });
        });
    </script>
</x-app-layout>