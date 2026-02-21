<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak</title>
    
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
                        'pulse-glow': 'pulse-glow 3s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        'pulse-glow': { '0%,100%': { opacity: '0.4' }, '50%': { opacity: '0.8' } },
                        float: { '0%,100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-18px)' } },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #080808; color: #fff; overflow-x: hidden; }
        .gradient-text {
            background: linear-gradient(135deg, #f87171 0%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #7c3aed 100%);
            position: relative; overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-primary::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(124,58,237,0.45); }
        .btn-primary:hover::after { opacity: 1; }
        .btn-primary span { position: relative; z-index: 1; }
        .orb { border-radius: 50%; filter: blur(80px); pointer-events: none; position: absolute; z-index: -1; }
        .dot-grid {
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            position: absolute; inset: 0; z-index: -2;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center relative">
    <!-- Grid -->
    <div class="dot-grid w-full h-full"></div>

    <!-- Orbs -->
    <div class="orb w-[500px] h-[500px] bg-red-600/10 top-[-100px] left-[-150px] animate-pulse-glow"></div>
    <div class="orb w-[400px] h-[400px] bg-rose-700/10 bottom-[-50px] right-[-100px] animate-pulse-glow" style="animation-delay: 1s"></div>

    <div class="relative z-10 text-center px-6 max-w-2xl mx-auto flex flex-col items-center">
        <!-- Error Code -->
        <h1 class="text-9xl font-black mb-4 gradient-text animate-float" style="letter-spacing: -0.05em; line-height: 1;">403</h1>
        
        <!-- Error Title -->
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Akses Ditolak</h2>
        
        <!-- Error Message -->
        <p class="text-gray-400 text-lg mb-10">Anda tidak memiliki izin (permission) yang cukup untuk mengakses halaman atau aksi ini.</p>

        <!-- Call to action -->
        <a href="{{ Auth::check() ? route('dashboard') : url('/') }}" class="btn-primary inline-flex items-center gap-2 text-white font-bold px-8 py-3.5 rounded-2xl text-base shadow-lg shadow-violet-500/20">
            <span>{{ Auth::check() ? 'Kembali ke Dashboard' : 'Kembali ke Beranda' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position:relative;z-index:1"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</body>
</html>
