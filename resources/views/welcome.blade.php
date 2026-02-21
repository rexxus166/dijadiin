<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIJADIIN - Ubah Ide Jadi Aplikasi Laravel dalam Detik</title>
    <meta name="description" content="Bangun aplikasi Laravel 12 yang siap pakai dengan mendeskripsikan gagasan Anda. Tanpa boilerplate, langsung jadi coding.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delay': 'float 6s ease-in-out 2s infinite',
                        'pulse-glow': 'pulse-glow 3s ease-in-out infinite',
                        'slide-up': 'slide-up 0.6s ease forwards',
                        'fade-in': 'fade-in 0.8s ease forwards',
                        'spin-slow': 'spin 12s linear infinite',
                        'bounce-soft': 'bounce-soft 2s ease-in-out infinite',
                        'shimmer': 'shimmer 2.5s linear infinite',
                    },
                    keyframes: {
                        float: { '0%,100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-18px)' } },
                        'pulse-glow': { '0%,100%': { opacity: '0.4' }, '50%': { opacity: '0.8' } },
                        'slide-up': { from: { opacity: '0', transform: 'translateY(30px)' }, to: { opacity: '1', transform: 'translateY(0)' } },
                        'fade-in': { from: { opacity: '0' }, to: { opacity: '1' } },
                        'bounce-soft': { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-6px)' } },
                        shimmer: { '0%': { backgroundPosition: '-200% center' }, '100%': { backgroundPosition: '200% center' } },
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #080808; color: #fff; }

        /* ---- Gradient text ---- */
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gradient-text-green {
            background: linear-gradient(135deg, #34d399 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ---- Buttons ---- */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #7c3aed 100%);
            position: relative; overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-primary::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(124,58,237,0.45); }
        .btn-primary:hover::after { opacity: 1; }
        .btn-primary span { position: relative; z-index: 1; }

        .btn-outline {
            border: 1px solid rgba(255,255,255,0.12);
            transition: border-color 0.25s, background 0.25s, transform 0.2s;
        }
        .btn-outline:hover {
            border-color: rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px);
        }

        /* ---- Cards ---- */
        .feature-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(255,255,255,0.15);
            box-shadow: 0 24px 60px rgba(0,0,0,0.5);
        }

        /* ---- Glow orbs ---- */
        .orb {
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        /* ---- Navbar ---- */
        #navbar { transition: background 0.4s, border-color 0.4s; }
        #navbar.scrolled {
            background: rgba(8,8,8,0.95) !important;
            border-color: rgba(255,255,255,0.08) !important;
            backdrop-filter: blur(20px);
        }

        /* ---- Grid dot bg ---- */
        .dot-grid {
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* ---- Step connector ---- */
        .step-line {
            position: absolute;
            top: 36px; left: calc(50% + 48px);
            width: calc(100% - 96px);
            height: 1px;
            background: linear-gradient(to right, rgba(96,165,250,0.4), rgba(167,139,250,0.4));
        }

        /* ---- Shimmer badge ---- */
        .badge-shimmer {
            background: linear-gradient(110deg, rgba(59,130,246,0.12) 0%, rgba(124,58,237,0.18) 40%, rgba(59,130,246,0.12) 100%);
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
            border: 1px solid rgba(99,102,241,0.3);
        }

        /* ---- Scroll reveal ---- */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* ---- Typing cursor ---- */
        .cursor::after {
            content: '|';
            animation: blink 1s step-end infinite;
            color: #60a5fa;
        }
        @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0; } }

        /* ---- Table ---- */
        .cmp-row:hover { background: rgba(255,255,255,0.03); }
        .check-yes { color: #34d399; }
        .check-no { color: #f87171; }

        /* ---- Floating badge ---- */
        .float-badge {
            position: absolute;
            background: rgba(15,15,15,0.9);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            backdrop-filter: blur(12px);
            padding: 10px 14px;
            font-size: 12px;
        }

        /* ---- Gradient border card ---- */
        .gradient-border {
            position: relative;
        }
        .gradient-border::before {
            content: '';
            position: absolute; inset: -1px;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(59,130,246,0.5), rgba(124,58,237,0.5));
            z-index: -1;
        }

        /* ---- CTA section bg ---- */
        .cta-bg {
            background: linear-gradient(135deg, rgba(17,24,39,1) 0%, rgba(30,27,75,1) 100%);
            border: 1px solid rgba(99,102,241,0.2);
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="antialiased">

    <!-- ============================
         NAVBAR
    ============================= -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 border-b border-transparent">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center shadow-lg shadow-violet-500/30 group-hover:scale-110 transition-transform">
                    <span class="text-white text-xs font-black">D</span>
                </div>
                <span class="font-bold text-base text-white tracking-tight">DIJADIIN</span>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-8 text-sm text-gray-400">
                <a href="#fitur" class="hover:text-white transition-colors duration-200 relative group">
                    Fitur
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#cara-kerja" class="hover:text-white transition-colors duration-200 relative group">
                    Cara Kerja
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#perbandingan" class="hover:text-white transition-colors duration-200 relative group">
                    Perbandingan
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Auth -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors px-4 py-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" id="btn-masuk" class="text-sm text-gray-400 hover:text-white transition-colors px-4 py-2">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" id="btn-mulai-gratis-nav"
                               class="btn-primary inline-flex items-center gap-1.5 text-white text-sm font-semibold px-5 py-2.5 rounded-xl">
                                <span>Mulai Gratis</span>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>
    </nav>

    <!-- ============================
         HERO SECTION
    ============================= -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden dot-grid pt-20">

        <!-- Background glow orbs -->
        <div class="orb absolute w-[600px] h-[600px] bg-blue-600/20 top-[-100px] left-[-150px] animate-pulse-glow"></div>
        <div class="orb absolute w-[500px] h-[500px] bg-violet-700/20 bottom-[-100px] right-[-150px] animate-pulse-glow" style="animation-delay:1.5s"></div>
        <div class="orb absolute w-[300px] h-[300px] bg-indigo-500/10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse-glow" style="animation-delay:0.8s"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 badge-shimmer rounded-full px-4 py-2 mb-8 opacity-0 animate-fade-in" style="animation-delay:0.2s;animation-fill-mode:forwards">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-bounce-soft"></div>
                <span class="text-blue-300 text-xs font-semibold tracking-widest uppercase">✦ AI-Powered App Builder</span>
            </div>

            <!-- Headline -->
            <h1 class="text-5xl md:text-7xl font-black leading-[1.05] mb-6 tracking-tight opacity-0 animate-slide-up" style="animation-delay:0.3s;animation-fill-mode:forwards">
                Ubah Ide Jadi Aplikasi
                <br>
                <span class="gradient-text">Laravel dalam Detik</span>
            </h1>

            <!-- Subheadline -->
            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed opacity-0 animate-slide-up" style="animation-delay:0.5s;animation-fill-mode:forwards">
                Bangun aplikasi Laravel 12 yang siap pakai dengan mendeskripsikan
                gagasan Anda. Tanpa boilerplate, langsung jadi coding.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 opacity-0 animate-slide-up" style="animation-delay:0.65s;animation-fill-mode:forwards">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" id="btn-mulai-gratis-hero"
                       class="btn-primary inline-flex items-center gap-2 text-white font-bold px-8 py-3.5 rounded-2xl text-base shadow-lg shadow-violet-500/20">
                        <span>Mulai Gratis Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position:relative;z-index:1"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endif
                <a href="#cara-kerja" id="btn-lihat-demo"
                   class="btn-outline inline-flex items-center gap-2 text-gray-300 font-semibold px-8 py-3.5 rounded-2xl text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                    Lihat Demo
                </a>
            </div>

            <!-- Floating stats badges -->
            <div class="relative h-16 mt-16 hidden md:block opacity-0 animate-fade-in" style="animation-delay:1s;animation-fill-mode:forwards">
                <div class="float-badge animate-float left-[5%] md:left-[8%]" style="top:-10px">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-gray-300 font-medium">Laravel 12 Ready</span>
                    </div>
                </div>
                <div class="float-badge animate-float-delay" style="top:-10px;right:5%;right:8%">
                    <div class="flex items-center gap-2">
                        <span class="text-blue-400">⚡</span>
                        <span class="text-gray-300 font-medium">Generate dalam detik</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-60 animate-bounce-soft">
            <span class="text-xs text-gray-500 tracking-widest uppercase">Scroll</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        </div>
    </section>

    <!-- ============================
         FEATURE CARDS
    ============================= -->
    <section id="fitur" class="py-24 px-6 relative overflow-hidden">
        <div class="orb absolute w-[400px] h-[400px] bg-blue-600/10 top-0 right-0"></div>
        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-16 reveal">
                <p class="text-blue-400 text-xs font-bold tracking-[0.2em] uppercase mb-3">Kenapa DIJADIIN?</p>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Semua yang kamu butuhkan</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="feature-card rounded-2xl p-7 reveal reveal-delay-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Generate Instan</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Deskripsikan aplikasimu dan dapatkan kode Laravel 12 yang siap pakai dalam hitungan detik. Tanpa delay, langsung bisa dijalankan.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="feature-card rounded-2xl p-7 reveal reveal-delay-2">
                    <div class="w-12 h-12 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Milik Kode 100%</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Semua kode adalah milikmu sepenuhnya. Tidak ada lock-in platform, tidak ada biaya bulanan. Deploy kapanpun ke server pilihanmu.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="feature-card rounded-2xl p-7 reveal reveal-delay-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Laravel 12</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Menggunakan Laravel versi terbaru yang selalu diperbarui dengan standar terbaik industri, struktur folder rapi dan best practices.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         HOW IT WORKS
    ============================= -->
    <section id="cara-kerja" class="py-24 px-6 bg-[#050505] relative overflow-hidden">
        <div class="orb absolute w-[350px] h-[350px] bg-violet-600/10 bottom-0 left-0"></div>
        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-20 reveal">
                <p class="text-violet-400 text-xs font-bold tracking-[0.2em] uppercase mb-3">Prosesnya Mudah</p>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Bagaimana Cara Kerjanya?</h2>
                <p class="text-gray-400 text-base">Hanya butuh 3 langkah untuk mewujudkan aplikasi impian Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 relative">

                <!-- Desktop connectors -->
                <div class="hidden md:block absolute top-9 left-[calc(33.333%+20px)] w-[calc(33.333%-40px)] h-px bg-gradient-to-r from-blue-500/40 to-violet-500/40"></div>
                <div class="hidden md:block absolute top-9 left-[calc(66.666%+20px)] w-[calc(33.333%-40px)] h-px bg-gradient-to-r from-violet-500/40 to-emerald-500/40"></div>

                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center reveal reveal-delay-1">
                    <div class="relative mb-6">
                        <div class="w-[72px] h-[72px] rounded-2xl bg-[#0f1623] border border-blue-500/30 flex items-center justify-center shadow-xl shadow-blue-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </div>
                        <div class="absolute -top-2.5 -right-2.5 w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white text-xs font-bold flex items-center justify-center shadow-lg shadow-blue-500/40">1</div>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-2">Tulis Ide</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Jelaskan aplikasi yang ingin Anda buat dengan bahasa natural yang detail dan jelas.</p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center reveal reveal-delay-2">
                    <div class="relative mb-6">
                        <div class="w-[72px] h-[72px] rounded-2xl bg-[#130f1e] border border-violet-500/30 flex items-center justify-center shadow-xl shadow-violet-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
                            </svg>
                        </div>
                        <div class="absolute -top-2.5 -right-2.5 w-6 h-6 rounded-full bg-gradient-to-br from-violet-500 to-violet-600 text-white text-xs font-bold flex items-center justify-center shadow-lg shadow-violet-500/40">2</div>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-2">AI Proses</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">AI kami menganalisis kebutuhan dan membangun struktur serta kode untuk Anda secara otomatis.</p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center reveal reveal-delay-3">
                    <div class="relative mb-6">
                        <div class="w-[72px] h-[72px] rounded-2xl bg-[#0d1a12] border border-emerald-500/30 flex items-center justify-center shadow-xl shadow-emerald-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                        </div>
                        <div class="absolute -top-2.5 -right-2.5 w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 text-white text-xs font-bold flex items-center justify-center shadow-lg shadow-emerald-500/40">3</div>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-2">Unduh ZIP</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Download file ZIP berisi full source code Laravel siap deploy langsung ke server Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         COMPARISON TABLE
    ============================= -->
    <section id="perbandingan" class="py-24 px-6 relative overflow-hidden">
        <div class="orb absolute w-[400px] h-[400px] bg-blue-600/8 top-0 right-0"></div>
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-14 reveal">
                <p class="text-blue-400 text-xs font-bold tracking-[0.2em] uppercase mb-3">DIJADIIN vs No-Code</p>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Kenapa memilih kami?</h2>
                <p class="text-gray-400">Kenapa DIJADIIN jauh lebih baik dari platform lain?</p>
            </div>

            <div class="reveal rounded-2xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.07)">
                <!-- Table header -->
                <div class="grid grid-cols-3 bg-[#111111] border-b border-white/7">
                    <div class="p-5 text-xs text-gray-500 font-bold uppercase tracking-widest">Fitur</div>
                    <div class="p-5 text-center border-x border-white/7">
                        <span class="gradient-text font-bold text-sm">DIJADIIN</span>
                    </div>
                    <div class="p-5 text-center text-xs text-gray-500 font-bold uppercase tracking-widest">No-Code Builders</div>
                </div>

                <!-- Rows -->
                @php
                $rows = [
                    ['Kepemilikan Kode',  '✓ 100% Milik Anda', '✗ Tidak'],
                    ['Framework Modern',  '✓ Standard Platform', '✓ Terbatas'],
                    ['Ekuitas Bisnis',    '✓ Teras Bisnis', '✗ Tidak'],
                    ['Custom Coding',     '✓ Bebas Modifikasi', '✗ Tidak'],
                    ['Hosting',           '✓ Bebas Pilih Server', '✗ Terikat Platform Mereka'],
                ];
                @endphp
                @foreach($rows as $i => $row)
                <div class="cmp-row grid grid-cols-3 border-b border-white/5 last:border-0 transition-colors duration-200 {{ $i%2===1 ? 'bg-white/[0.015]' : '' }}">
                    <div class="p-5 text-sm text-gray-300">{{ $row[0] }}</div>
                    <div class="p-5 text-center border-x border-white/5">
                        <span class="text-sm {{ str_starts_with($row[1],'✓') ? 'text-emerald-400' : 'text-gray-600' }} font-medium">{{ $row[1] }}</span>
                    </div>
                    <div class="p-5 text-center">
                        <span class="text-sm {{ str_starts_with($row[2],'✓') ? 'text-gray-400' : 'text-red-400' }} font-medium">{{ $row[2] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================
         BOTTOM CTA
    ============================= -->
    <section class="py-24 px-6 bg-[#050505]">
        <div class="max-w-3xl mx-auto reveal">
            <div class="cta-bg relative rounded-3xl p-14 text-center overflow-hidden">
                <!-- Decoration orbs inside card -->
                <div class="orb absolute w-64 h-64 bg-blue-600/15 -top-16 -right-16 pointer-events-none"></div>
                <div class="orb absolute w-64 h-64 bg-violet-700/15 -bottom-16 -left-16 pointer-events-none"></div>
                <!-- Grid dots inside card -->
                <div class="absolute inset-0 dot-grid opacity-30 rounded-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 badge-shimmer rounded-full px-4 py-2 mb-6">
                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></div>
                        <span class="text-indigo-300 text-xs font-semibold tracking-widest uppercase">Daftar Gratis Sekarang</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-white mb-4 leading-tight">
                        Siap Membangun Aplikasi<br>Laravel Anda?
                    </h2>
                    <p class="text-gray-400 text-base mb-8 max-w-md mx-auto">
                        Daftar sekarang, dan nikmati kemudahan membangun aplikasi bersama AI.
                    </p>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" id="btn-mulai-gratis-cta"
                           class="btn-primary inline-flex items-center gap-2 text-white font-bold px-8 py-3.5 rounded-2xl text-base shadow-xl shadow-violet-500/25">
                            <span>Mulai Gratis Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position:relative;z-index:1"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         FOOTER
    ============================= -->
    <footer class="border-t border-white/5 bg-[#050505]">
        <div class="max-w-6xl mx-auto px-6 py-12">

            <!-- Top row: Brand + Columns -->
            <div class="flex flex-col md:flex-row items-start justify-between gap-10 mb-10">

                <!-- Brand + tagline -->
                <div class="flex flex-col gap-4 max-w-xs">
                    <a href="/" class="flex items-center gap-2.5">
                        <img src="{{ asset('assets/icon/icon.png') }}" alt="DIJADIIN" class="h-8 w-8 rounded-lg">
                        <span class="font-bold text-base text-white tracking-tight">DIJADIIN</span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Bangun aplikasi Laravel dari ide menjadi kode nyata — cepat, tanpa boilerplate, langsung siap deploy.
                    </p>
                </div>

                <!-- Nav columns -->
                <div class="flex flex-col sm:flex-row gap-10">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Produk</p>
                        <ul class="flex flex-col gap-3 text-sm text-gray-500">
                            <li><a href="#fitur" class="hover:text-white transition-colors">Fitur</a></li>
                            <li><a href="#cara-kerja" class="hover:text-white transition-colors">Cara Kerja</a></li>
                            <li><a href="#perbandingan" class="hover:text-white transition-colors">Perbandingan</a></li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Akun</p>
                        <ul class="flex flex-col gap-3 text-sm text-gray-500">
                            @if (Route::has('login'))
                                <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar Gratis</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Bottom row: copyright + social -->
            <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-sm text-gray-600">© {{ date('Y') }} DIJADIIN. All rights reserved.</span>
                <div class="flex items-center gap-5">
                    <a href="#" aria-label="GitHub" class="text-gray-600 hover:text-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844a9.59 9.59 0 0 1 2.504.337c1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.02 10.02 0 0 0 22 12.017C22 6.484 17.522 2 12 2z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter / X" class="text-gray-600 hover:text-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="text-gray-600 hover:text-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </footer>

    <!-- ============================
         JAVASCRIPT
    ============================= -->
    <script>
        // === Navbar scroll effect ===
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        });

        // === Scroll reveal (Intersection Observer) ===
        const reveals = document.querySelectorAll('.reveal');
        const revealObs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(el => revealObs.observe(el));

        // === Typing effect on hero gradient text ===
        const words = ['Laravel dalam Detik', 'Backend Impian', 'API Powerful', 'Kode Production'];
        const el = document.querySelector('.gradient-text');
        let wi = 0, ci = 0, deleting = false;
        function type() {
            const target = words[wi];
            if (!deleting) {
                el.textContent = target.slice(0, ++ci);
                if (ci === target.length) { deleting = true; return setTimeout(type, 2200); }
            } else {
                el.textContent = target.slice(0, --ci);
                if (ci === 0) { deleting = false; wi = (wi + 1) % words.length; }
            }
            setTimeout(type, deleting ? 55 : 90);
        }
        setTimeout(type, 1400);

        // === Smooth hover glow on feature cards ===
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                card.style.background = `radial-gradient(200px at ${x}px ${y}px, rgba(99,102,241,0.08), rgba(255,255,255,0.02))`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.background = '';
            });
        });

        // === Table row hover ===
        document.querySelectorAll('.cmp-row').forEach(row => {
            row.addEventListener('mouseenter', () => row.style.background = 'rgba(255,255,255,0.03)');
            row.addEventListener('mouseleave', () => row.style.background = '');
        });

        // === Parallax on hero orbs ===
        window.addEventListener('mousemove', (e) => {
            const orbs = document.querySelectorAll('section:first-of-type .orb');
            const cx = window.innerWidth / 2, cy = window.innerHeight / 2;
            const dx = (e.clientX - cx) / cx, dy = (e.clientY - cy) / cy;
            orbs.forEach((orb, i) => {
                const factor = (i + 1) * 10;
                orb.style.transform = `translate(${dx * factor}px, ${dy * factor}px)`;
            });
        });
    </script>

</body>
</html>
