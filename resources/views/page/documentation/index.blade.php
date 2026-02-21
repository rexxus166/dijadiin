@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h2 class="font-bold text-xl md:text-3xl text-gray-900 dark:text-white leading-tight tracking-tight mt-4">
                Documentation
            </h2>
            <p class="text-sm dark:text-gray-400 mt-1">Panduan Lengkap Penggunaan DIJADIIN AI Builder.</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-12 bg-[#0a0d12] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Intro Section --}}
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl p-8 shadow-xl relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                </div>

                <h3
                    class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500 mb-4 inline-block">
                    Selamat Datang di DIJADIIN
                </h3>
                <p class="text-gray-400 leading-relaxed max-w-3xl">
                    DIJADIIN adalah <strong>AI App Generator</strong> canggih yang dibangun untuk mempercepat proses
                    pembuatan aplikasi Laravel.
                    Dilengkapi dengan integrasi Gemini AI, sistem ini memungkinkan Anda membuat aplikasi utuh, struktur
                    database, hingga halaman view secara otomatis
                    hanya dengan memberikan prompt teks yang jelas.
                </p>
            </div>

            {{-- Steps System --}}
            <div>
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Langkah-langkah Penggunaan
                </h3>

                <div
                    class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-[#30363d] before:to-transparent">

                    {{-- Step 1 --}}
                    <div
                        class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-[#0a0d12] bg-[#161b22] text-blue-500 font-bold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-transform duration-300 group-hover:scale-110">
                            1
                        </div>
                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-[#161b22] border border-[#30363d] p-6 rounded-2xl hover:border-blue-500/50 transition-colors shadow-lg shadow-black/20">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-200">Membuat Proyek Baru</h4>
                            </div>
                            <p class="text-sm text-gray-400 leading-relaxed mb-3">
                                Mulai dengan menuju ke halaman <strong>My Projects</strong> atau langsung klik
                                <strong>Create New Project</strong>. Anda akan diarahkan ke form AI Builder.
                            </p>
                            <ul class="text-sm text-gray-500 space-y-1.5 list-disc list-inside">
                                <li>Isi <strong>Project Details</strong> seperti nama dan deskripsi.</li>
                                <li>Pilih dan konfigurasikan <strong>Database</strong> (MySQL, PostgreSQL, atau SQLite).
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-[#0a0d12] bg-[#161b22] text-emerald-500 font-bold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-transform duration-300 group-hover:scale-110">
                            2
                        </div>
                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-[#161b22] border border-[#30363d] p-6 rounded-2xl hover:border-emerald-500/50 transition-colors shadow-lg shadow-black/20">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-200">AI Context Prompt</h4>
                            </div>
                            <p class="text-sm text-gray-400 leading-relaxed">
                                Ini adalah bagian terpenting. Pada kolom <strong>AI Context Prompt</strong>, beritahu Gemini
                                AI gambaran utuh tentang aplikasi yang ingin Anda bangun.
                                <br><br>
                                <span class="bg-[#21262d] px-2 py-1 rounded text-gray-300 text-xs font-mono">Contoh:
                                    "Buatkan saya aplikasi kasir (POS) yang memiliki fitur manajemen stok barang, kasir, dan
                                    laporan penjualan bulanan."</span>
                            </p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-[#0a0d12] bg-[#161b22] text-purple-500 font-bold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-transform duration-300 group-hover:scale-110">
                            3
                        </div>
                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-[#161b22] border border-[#30363d] p-6 rounded-2xl hover:border-purple-500/50 transition-colors shadow-lg shadow-black/20">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-200">Proses Pembangunan (Streaming)</h4>
                            </div>
                            <p class="text-sm text-gray-400 leading-relaxed">
                                Setelah klik <strong>Generate Project</strong>, sistem akan menampilkan layar <i>loading</i>
                                pembangunan.
                                Tunggu beberapa saat selagi AI Arsitek kami menuliskan logika, struktur MVC, dan meracik
                                tampilan aplikasi impian Anda. Proses ini termonitor lewat progress bar yang interaktif.
                            </p>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-[#0a0d12] bg-[#161b22] text-pink-500 font-bold shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 transition-transform duration-300 group-hover:scale-110">
                            4
                        </div>
                        <div
                            class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-[#161b22] border border-[#30363d] p-6 rounded-2xl hover:border-pink-500/50 transition-colors shadow-lg shadow-black/20">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-pink-500/10 flex items-center justify-center text-pink-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-200">Eksplorasi & Modifikasi</h4>
                            </div>
                            <p class="text-sm text-gray-400 leading-relaxed">
                                Setelah selesai, Anda akan diarahkan otomatis menuju <strong>Web File Explorer</strong>.
                                Di sini Anda dapat melihat struktur file proyek secara penuh, membuka kode menggunakan
                                <i>code editor</i> yang disediakan (Monaco Editor), serta melakukan perubahan secara
                                langsung pada file hasil karya AI jika dibutuhkan (Auto Scaffold).
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tips Section --}}
            <div
                class="bg-gradient-to-br from-[#161b22] to-[#1c212b] border border-[#30363d] rounded-2xl p-6 shadow-xl flex gap-4 mt-12 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-yellow-500/80"></div>
                <div class="shrink-0 mt-1">
                    <div class="w-10 h-10 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-200 mb-1">Tips untuk Prompt yang Baik</h4>
                    <p class="text-sm text-gray-400 mb-3">Semakin spesifik prompt Anda, semakin bagus pula hasil aplikasi
                        yang dicetak. Coba tulis skenario spesifik tabel yang Anda butuhkan (misal: "Saya butuh tabel
                        products dan categories") dan jangan lupa berikan penjelasan alur logika utamanya.</p>
                </div>
            </div>

            <div class="text-center pt-8 pb-4 text-xs font-medium text-gray-600">
                &copy; {{ date('Y') }} DIJADIIN AI. The Future of App Generation.
            </div>

        </div>
    </div>
@endsection
