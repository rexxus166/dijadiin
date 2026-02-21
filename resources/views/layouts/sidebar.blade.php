{{-- ===== DESKTOP SIDEBAR ===== --}}
<aside :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden border-r-0'"
    class="bg-[#0d1117] border-r border-[#21262d] z-10 hidden sm:flex flex-col shrink-0 sticky top-0 h-screen transition-all duration-300 ease-in-out"
    style="will-change: width;">
    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-[#21262d] shrink-0">
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
            class="flex items-center gap-3">
            <div
                class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30 shrink-0">
                <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin" class="w-6 h-6 object-contain" />
            </div>
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="whitespace-nowrap">
                <p class="font-bold text-sm text-white leading-tight">DIJADIIN</p>
                <p class="text-[10px] text-blue-400 font-medium leading-tight">AI App Generator</p>
            </div>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overflow-x-hidden">

        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
                :title="!sidebarOpen ? 'Admin Dashboard' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap">Dashboard</span>
            </a>

            {{-- User Management --}}
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users.index') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
                :title="!sidebarOpen ? 'User Management' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap flex items-center gap-2">
                    User Management
                </span>
            </a>

            {{-- Templates Management --}}
            <a href="{{ route('admin.templates.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.templates.*') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
                :title="!sidebarOpen ? 'Templates' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap">Templates</span>
            </a>

            {{-- AI Logs (coming soon) --}}
            <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 cursor-not-allowed select-none"
                :title="!sidebarOpen ? 'AI Logs (Soon)' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap flex items-center gap-2">
                    AI Logs
                    <span class="text-[10px] bg-[#21262d] text-gray-600 px-1.5 py-0.5 rounded-md">Soon</span>
                </span>
            </a>

            {{-- System Settings (coming soon) --}}
            <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 cursor-not-allowed select-none"
                :title="!sidebarOpen ? 'System Settings (Soon)' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap flex items-center gap-2">
                    System Settings
                    <span class="text-[10px] bg-[#21262d] text-gray-600 px-1.5 py-0.5 rounded-md">Soon</span>
                </span>
            </a>

            {{-- Reports (coming soon) --}}
            <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 cursor-not-allowed select-none"
                :title="!sidebarOpen ? 'Reports (Soon)' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap flex items-center gap-2">
                    Reports
                    <span class="text-[10px] bg-[#21262d] text-gray-600 px-1.5 py-0.5 rounded-md">Soon</span>
                </span>
            </a>
        @else
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
                :title="!sidebarOpen ? 'My Projects' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap">My Projects</span>
            </a>

            {{-- Templates --}}
            <a href="{{ route('templates.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('templates.*') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
                :title="!sidebarOpen ? 'Templates' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap">Templates</span>
            </a>

            {{-- API Keys --}}
            <a href="{{ route('api-keys.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('api-keys.*') ? 'bg-yellow-500/15 text-yellow-400 border border-yellow-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
                :title="!sidebarOpen ? 'API Keys' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path
                        d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4" />
                </svg>
                <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="whitespace-nowrap">API Keys</span>
            </a>
        @endif

        {{-- Settings --}}
        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('profile.edit') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-500 hover:bg-[#161b22] hover:text-gray-300' }}"
            :title="!sidebarOpen ? 'Settings' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                <circle cx="12" cy="12" r="3" />
                <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="whitespace-nowrap">Settings</span>
        </a>

        @if (auth()->user()->role !== 'admin')
            {{-- Divider --}}
            <div class="pt-2 mt-2 border-t border-[#21262d]">
                <a href="{{ route('documentation.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('documentation.index') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/20' : 'text-gray-600 hover:bg-[#161b22] hover:text-gray-400' }}"
                    :title="!sidebarOpen ? 'Documentation' : ''">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="shrink-0">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="whitespace-nowrap">Documentation</span>
                </a>
            </div>
        @endif

    </nav>

    {{-- User Profile --}}
    <div class="border-t border-[#21262d] p-3 shrink-0">
        <div class="flex items-center gap-2.5">
            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/avatar/avatar-1.png') }}"
                alt="{{ Auth::user()->name }}"
                class="w-9 h-9 rounded-full object-cover shrink-0 border border-[#30363d]"
                :title="!sidebarOpen ? '{{ Auth::user()->name }}' : ''">
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-200 delay-100"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="flex flex-col truncate flex-1 min-w-0 whitespace-nowrap">
                <span class="text-xs font-semibold text-gray-200 truncate leading-tight">{{ Auth::user()->name }}</span>
                <span class="text-[10px] text-gray-500 truncate leading-tight">{{ Auth::user()->email }}</span>
            </div>
            <form x-show="sidebarOpen" method="POST" action="{{ route('logout') }}"
                x-transition:enter="transition-opacity duration-200 delay-100" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-100"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                @csrf
                <button type="submit" title="Log Out"
                    class="w-8 h-8 flex items-center justify-center text-gray-600 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>

{{-- ===== FLOATING TOGGLE BUTTON (Desktop) ===== --}}
<button @click="toggleSidebar()" :title="sidebarOpen ? 'Sembunyikan Sidebar' : 'Tampilkan Sidebar'"
    class="hidden sm:flex fixed z-50 items-center justify-center w-7 h-7 rounded-full bg-[#21262d] border border-[#30363d] text-gray-400 hover:text-white hover:bg-[#30363d] hover:border-blue-500/50 shadow-lg transition-all duration-300 cursor-pointer"
    :style="sidebarOpen ? 'left: calc(16rem - 14px); top: 50%;' : 'left: 8px; top: 50%;'"
    style="transform: translateY(-50%);">
    {{-- Chevron icon rotates based on state --}}
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" :class="sidebarOpen ? '' : 'rotate-180'"
        class="transition-transform duration-300">
        <polyline points="15 18 9 12 15 6"></polyline>
    </svg>
</button>


{{-- ===== MOBILE HEADER ===== --}}
<div class="sm:hidden flex items-center justify-between p-4 bg-[#0d1117] border-b border-[#21262d] shrink-0">
    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
        class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
            <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin" class="w-5 h-5 object-contain" />
        </div>
        <span class="font-bold text-sm text-white">DIJADIIN</span>
    </a>

    <div x-data="{ open: false }">
        <button @click="open = !open"
            class="p-2 rounded-lg text-gray-400 hover:text-gray-200 hover:bg-[#161b22] focus:outline-none transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div x-show="open" @click.away="open = false" style="display: none;"
            class="absolute top-16 right-0 w-full bg-[#0d1117] shadow-xl border-b border-[#21262d] z-50">
            <div class="px-3 py-3 space-y-1">
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600/20 text-blue-400' : 'text-gray-400 hover:bg-[#161b22]' }}">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.index') ? 'bg-blue-600/20 text-blue-400' : 'text-gray-400 hover:bg-[#161b22]' }}">User
                        Management</a>
                    <a href="#"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 cursor-not-allowed flex items-center justify-between">AI
                        Logs <span class="text-[10px] bg-[#21262d] text-gray-600 px-1.5 py-0.5 rounded-md">Soon</span></a>
                    <a href="#"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 cursor-not-allowed flex items-center justify-between">System
                        Settings <span
                            class="text-[10px] bg-[#21262d] text-gray-600 px-1.5 py-0.5 rounded-md">Soon</span></a>
                    <a href="#"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 cursor-not-allowed flex items-center justify-between">Reports
                        <span class="text-[10px] bg-[#21262d] text-gray-600 px-1.5 py-0.5 rounded-md">Soon</span></a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-600/20 text-blue-400' : 'text-gray-400 hover:bg-[#161b22]' }}">My
                        Projects</a>
                    <a href="{{ route('api-keys.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('api-keys.*') ? 'bg-yellow-500/15 text-yellow-400' : 'text-gray-400 hover:bg-[#161b22]' }} flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4">
                            </path>
                        </svg>
                        API Keys
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('profile.edit') ? 'bg-blue-600/20 text-blue-400' : 'text-gray-400 hover:bg-[#161b22]' }}">Settings</a>

                <div class="mt-3 pt-3 border-t border-[#21262d]">
                    <div class="flex items-center gap-3 px-3 mb-3">
                        <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/avatar/avatar-1.png') }}"
                            alt="{{ Auth::user()->name }}"
                            class="w-8 h-8 rounded-full object-cover border border-[#30363d]">
                        <div>
                            <div class="text-sm font-semibold text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 transition-colors">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>