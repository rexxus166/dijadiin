<!-- Global Full-Screen Loading Overlay with Progress Bar -->
<div x-data="{ 
            isNavigating: false, 
            progress: 0,
            startLoading(event = null) {
                // Jangan start loading kalau user nge-klik tombol kanan atau pencet ctrl/cmd (open new tab)
                if (event && (event.ctrlKey || event.metaKey || event.shiftKey)) return;

                // Membatalkan loading screen jika event sudah dibatalkan (menggunakan ajax e.preventDefault()) 
                if (event && event.defaultPrevented) return;

                // Membatalkan loading screen jika elemen yang memicunya memiliki atribut 'data-no-global-loading'
                if (event && event.target && event.target.closest && event.target.closest('[data-no-global-loading]')) return;
                
                this.isNavigating = true;
                this.progress = 0;
                let interval = setInterval(() => {
                    if (this.progress < 95) {
                        let increment = Math.random() * (95 - this.progress) * 0.2;
                        this.progress = Math.min(95, this.progress + increment);
                    }
                }, 150);
            },
            handleLinkClick(e) {
                // Cari elemen 'a' ('link') terdekat dari target yang di-klik pengguna
                const link = e.target.closest('a');
                
                // Kalau klik bukan di link, ada atribut open new tab (_blank), link-nya kosong, atau link mengarah ke anchor (#), acuhkan.
                if (!link || link.target === '_blank' || !link.href || link.href.includes('#') || link.href.startsWith('javascript:')) return;
                
                // Cek apakah link mengarah ke website internal kita, bukan link ke domain lain
                if (link.hostname === window.location.hostname) {
                    this.startLoading(e);
                }
            }
        }" @submit.window="startLoading($event)" @click.window="handleLinkClick($event)" x-show="isNavigating"
    x-transition.opacity.duration.300ms style="display: none;"
    class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-slate-900/80 dark:bg-[#0f1115]/80 backdrop-blur-sm">

    <!-- Animated Logo Container -->
    <div class="relative flex flex-col items-center justify-center mb-8">
        <div class="absolute inset-0 bg-[#135bec]/20 rounded-full blur-2xl animate-pulse"></div>
        <img src="{{ asset('assets/icon/burung-utama.png') }}" alt="Loading..." x-show="isNavigating"
            x-transition:enter="transition ease-out duration-700 delay-150"
            x-transition:enter-start="opacity-0 translate-y-4 scale-75"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            class="w-24 h-24 object-contain relative z-10 drop-shadow-[0_0_15px_rgba(19,91,236,0.5)]" />
    </div>

    <!-- Progress Bar & Text Container -->
    <div class="w-full max-w-[280px] flex flex-col items-center gap-3 relative z-10">
        <!-- Dynamic Percentage Text -->
        <div class="flex items-end justify-center gap-1">
            <span class="text-3xl font-black tracking-tight text-white font-mono" x-text="Math.round(progress)">0</span>
            <span class="text-lg font-bold text-[#135bec] mb-1">%</span>
        </div>

        <!-- Loading Bar Track -->
        <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden relative shadow-inner">
            <!-- Moving Gradient Bar -->
            <div class="h-full bg-gradient-to-r from-blue-500 hover:to-indigo-500 via-[#135bec] to-cyan-400 transition-all duration-300 ease-out relative"
                :style="`width: ${progress}%`">
                <!-- Shinning sweep effect on the bar itself -->
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent w-full animate-[shimmer_1.5s_infinite]">
                </div>
            </div>
        </div>

        <p class="text-[11px] font-medium text-slate-400 mt-1 uppercase tracking-widest animate-pulse">
            Menyiapkan Halaman...
        </p>
    </div>
</div>