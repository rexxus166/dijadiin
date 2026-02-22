{{-- Logout Confirmation Modal --}}
<div x-show="showLogoutModal"
    class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;" x-cloak>

    <div @click.away="showLogoutModal = false"
        class="relative w-full max-w-md p-6 mx-4 bg-[#161b22] border border-[#30363d] rounded-2xl shadow-2xl"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        {{-- Close Button --}}
        <button @click="showLogoutModal = false" type="button"
            class="absolute top-4 right-4 text-gray-400 hover:text-white bg-[#21262d] hover:bg-red-500/20 hover:border-red-500/30 border border-[#30363d] rounded-lg p-1.5 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Content --}}
        <div class="text-center">
            <div
                class="w-16 h-16 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center mx-auto mb-4 text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
            </div>
            <h3 class="mb-2 text-xl font-bold text-white">Konfirmasi Logout</h3>
            <p class="mb-6 text-sm text-gray-400">Apakah Anda yakin ingin keluar dari aplikasi? Anda harus login kembali
                untuk mengakses sesi Anda.</p>

            <div class="flex justify-center gap-3">
                <button @click="showLogoutModal = false" type="button"
                    class="px-5 py-2.5 text-sm font-medium text-gray-300 bg-[#21262d] border border-[#30363d] rounded-xl hover:bg-[#30363d] hover:text-white transition-colors cursor-pointer">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 border border-red-500 rounded-xl hover:bg-red-700 hover:border-red-600 shadow-lg shadow-red-600/20 transition-all cursor-pointer">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
