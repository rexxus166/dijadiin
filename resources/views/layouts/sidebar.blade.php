<aside
    class="w-64 bg-white dark:bg-[#161b22] border-r border-gray-100 dark:border-gray-800 z-10 hidden sm:block shrink-0 sticky top-0 h-screen">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-100 dark:border-gray-800">
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                class="flex items-center gap-3">
                <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin" class="block h-9 w-auto" />
                <span class="font-bold text-xl text-gray-800 dark:text-gray-200">Dijadiin</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg w-full transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    {{ __('Admin Dashboard') }}
                </a>
            @else
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg w-full transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    {{ __('My Projects') }}
                </a>
            @endif

            <a href="{{ route('profile.edit') }}"
                class="flex items-center px-4 py-3 rounded-lg w-full transition-colors {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ __('Settings') }}
            </a>
        </div>

        <!-- User Profile & Logout -->
        <div class="border-t border-gray-100 dark:border-gray-800 p-3 shrink-0">
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/avatar/avatar-1.png') }}"
                        alt="{{ Auth::user()->name }}"
                        class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col truncate">
                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate leading-tight">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="text-[10px] text-gray-500 truncate leading-tight">{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full m-0">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-1.5 px-3 py-1.5 border border-transparent rounded-lg shadow-sm text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:text-red-400 dark:bg-red-900/20 dark:hover:bg-red-900/40 focus:outline-none transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Header -->
<div
    class="sm:hidden flex items-center justify-between p-4 bg-white dark:bg-[#161b22] border-b border-gray-100 dark:border-gray-800 shrink-0">
    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
        class="flex items-center gap-2">
        <img src="{{ asset('assets/icon/icon.png') }}" alt="Dijadiin" class="block h-8 w-auto" />
        <span class="font-bold text-lg text-gray-800 dark:text-gray-200">Dijadiin</span>
    </a>

    <div x-data="{ open: false }">
        <button @click="open = !open"
            class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div x-show="open" @click.away="open = false" style="display: none;"
            class="absolute top-16 right-0 w-full bg-white dark:bg-[#161b22] shadow-lg border-b border-gray-100 dark:border-gray-800 z-50">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700' }}">{{ __('Admin Dashboard') }}</a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700' }}">{{ __('My Projects') }}</a>
                @endif
                <a href="{{ route('profile.edit') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700' }}">{{ __('Settings') }}</a>

                <form method="POST" action="{{ route('logout') }}"
                    class="mt-4 border-t border-gray-200 dark:border-gray-800 pt-4">
                    @csrf
                    <div class="px-3 mb-4 flex items-center gap-3 overflow-hidden">
                        <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/avatar/avatar-1.png') }}"
                            alt="{{ Auth::user()->name }}"
                            class="w-10 h-10 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col truncate">
                            <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>