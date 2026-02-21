@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h2 class="font-bold text-xl md:text-2xl text-gray-900 dark:text-white leading-tight tracking-tight">
                User Management
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage user access, roles, and platform activity.</p>
        </div>
        <div class="flex items-center" x-data>
            <button @click="$dispatch('open-create-modal')"
                class="flex items-center gap-2 px-4 py-2 bg-[#3b82f6] hover:bg-blue-600 text-white text-sm font-medium rounded-xl shadow-[0_0_15px_rgba(59,130,246,0.5)] transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New User
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Create User Modal -->
            <div x-data="{ isOpen: false, showPassword: false }" @open-create-modal.window="isOpen = true" x-show="isOpen" style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">
                <div @click.away="isOpen = false"
                    class="bg-[#12151a] border border-[#3b82f6]/40 rounded-2xl p-6 shadow-[0_0_30px_rgba(59,130,246,0.15)] max-w-md w-full text-left font-sans">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3 text-[#3b82f6]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            <h2 class="text-xl font-bold text-white">Add New User</h2>
                        </div>
                        <button @click="isOpen = false" class="text-gray-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Full
                                    Name</label>
                                <input type="text" name="name" required
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-[#3b82f6] focus:ring-1 focus:ring-[#3b82f6] transition-colors"
                                    placeholder="John Doe" value="{{ old('name') }}">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Email
                                    Address</label>
                                <input type="email" name="email" required
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-[#3b82f6] focus:ring-1 focus:ring-[#3b82f6] transition-colors"
                                    placeholder="john@example.com" value="{{ old('email') }}">
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Account
                                    Role</label>
                                <div class="relative">
                                    <select name="role" required
                                        class="appearance-none w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 pr-10 text-sm text-white focus:outline-none focus:border-[#3b82f6] focus:ring-1 focus:ring-[#3b82f6] transition-colors">
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator
                                        </option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="relative">
                                <label
                                    class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Password</label>
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 pr-10 text-sm text-white focus:outline-none focus:border-[#3b82f6] focus:ring-1 focus:ring-[#3b82f6] transition-colors"
                                    placeholder="Minimum 8 characters">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute bottom-2.5 right-3 text-gray-500 hover:text-gray-300 focus:outline-none">
                                    <svg x-show="showPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!showPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.182-5.415m4.35-1.125a3 3 0 00-3.692 3.692M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Password Confirmation -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Confirm
                                    Password</label>
                                <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" required
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-[#3b82f6] focus:ring-1 focus:ring-[#3b82f6] transition-colors"
                                    placeholder="Retype password">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8">
                            <button type="button" @click="isOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white transition-colors">Cancel</button>
                            <button type="submit"
                                class="bg-[#3b82f6] hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg text-sm transition-colors shadow-[0_0_15px_rgba(59,130,246,0.4)]">Create
                                User</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total
                            Users
                        </div>
                        <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-[#3b82f6]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-3">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</p>
                        <div
                            class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +12%
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active
                            Today</div>
                        <div
                            class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-[#10b981]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-3">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">845</p>
                        <div
                            class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +5%
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">New This
                            Week</div>
                        <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-[#a855f7]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-3">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($newUsersThisWeek) }}
                        </p>
                        <div
                            class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +2%
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pending
                            Approvals</div>
                        <div class="p-2 rounded-lg bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-[#f97316]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-end gap-3">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">5</p>
                        <div
                            class="text-[11px] font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-[#1f2532] px-2 py-1 rounded-md mb-1">
                            Needs Review
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any() || $errors->userDeletion->any())
                <div
                    class="mb-6 p-4 rounded-xl relative border border-red-500/30 bg-red-50/50 dark:bg-red-500/10 text-red-600 dark:text-red-400">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold mb-1">Could not process your request:</h3>
                            <ul class="list-disc list-inside text-sm space-y-1 opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                @foreach ($errors->userDeletion->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success Alert -->
            @if (session('status'))
                <div
                    class="mb-6 p-4 rounded-xl relative border border-emerald-500/30 bg-emerald-50/50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-bold font-sans">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Table Section -->
            <div
                class="bg-white dark:bg-[#161b22] border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden">

                <!-- Filters -->
                <form method="GET" action="{{ route('admin.users.index') }}"
                    class="p-4 border-b border-gray-100 dark:border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, email, or role..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-[#12161b] border-none text-sm text-gray-900 dark:text-white rounded-xl focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700 placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="relative">
                            <select name="role" onchange="this.form.submit()"
                                class="appearance-none bg-gray-50 dark:bg-[#12161b] border-none text-sm font-medium text-gray-700 dark:text-gray-300 rounded-xl px-4 py-2.5 pr-10 focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700 outline-none w-full md:w-auto">
                                <option value="All Roles" {{ request('role') == 'All Roles' ? 'selected' : '' }}>All Roles
                                </option>
                                <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>User</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()"
                                class="appearance-none bg-gray-50 dark:bg-[#12161b] border-none text-sm font-medium text-gray-700 dark:text-gray-300 rounded-xl px-4 py-2.5 pr-10 focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700 outline-none w-full md:w-auto">
                                <option value="Status: All" {{ request('status') == 'Status: All' ? 'selected' : '' }}>
                                    Status: All</option>
                                <option value="Online" {{ request('status') == 'Online' ? 'selected' : '' }}>Online
                                </option>
                                <option value="Offline" {{ request('status') == 'Offline' ? 'selected' : '' }}>Offline
                                </option>
                                <option value="Suspended" {{ request('status') == 'Suspended' ? 'selected' : '' }}>
                                    Suspended</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <button type="submit" title="Filter Users"
                            class="flex items-center justify-center w-[40px] h-[40px] rounded-xl bg-gray-50 dark:bg-[#12161b] text-gray-500 hover:text-[#3b82f6] dark:text-gray-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead
                            class="text-[11px] text-gray-500 dark:text-gray-400 font-bold uppercase bg-gray-50/50 dark:bg-[#1f2532] border-b border-gray-100 dark:border-gray-800 tracking-wider">
                            <tr>
                                <th class="px-6 py-4 w-10">
                                    <div
                                        class="w-4 h-4 border border-gray-300 dark:border-gray-600 rounded bg-transparent">
                                    </div>
                                </th>
                                <th class="px-6 py-4">USER</th>
                                <th class="px-6 py-4">ROLE</th>
                                <th class="px-6 py-4">STATUS</th>
                                <th class="px-6 py-4">PROJECTS CREATED</th>
                                <th class="px-6 py-4">LAST ACTIVE</th>
                                <th class="px-6 py-4 text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                            @forelse ($users as $u)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors">
                                    <td class="px-6 py-4">
                                        <div
                                            class="w-4 h-4 border border-gray-300 dark:border-gray-600 rounded bg-transparent">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <img src="{{ $u->avatar ? asset($u->avatar) : asset('assets/avatar/avatar-1.png') }}"
                                                    class="w-9 h-9 rounded-full object-cover border border-gray-200 dark:border-[#30363d]">
                                                @if ($u->computed_status === 'Online')
                                                    <span
                                                        class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-[#161b22] rounded-full"></span>
                                                @elseif($u->computed_status === 'Suspended')
                                                    <span
                                                        class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-[#161b22] rounded-full"></span>
                                                @else
                                                    <span
                                                        class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-gray-400 border-2 border-white dark:border-[#161b22] rounded-full"></span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white text-sm">
                                                    {{ $u->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $u->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold 
                                        @if (strtolower($u->role) === 'admin') bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-[#3b82f6]
                                        @elseif(strtolower($u->role) === 'editor') bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-[#a855f7]
                                        @else bg-gray-100 dark:bg-gray-500/10 text-gray-600 dark:text-gray-400 @endif
                                        ">
                                            {{ ucfirst($u->role ?? 'User') }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 font-medium 
                                    @if ($u->computed_status === 'Suspended') text-red-500 dark:text-red-400
                                    @elseif($u->computed_status === 'Online') text-emerald-500 dark:text-emerald-400
                                    @else text-gray-500 dark:text-gray-400 @endif
                                ">
                                        {{ $u->computed_status }}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        {{ $u->generated_projects_count ?? 0 }}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        {{ $u->updated_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2" x-data="{ showSuspendModal: false, showDeleteModal: false, showDeletePassword: false }">
                                            <!-- Suspend/Activate Button -->
                                            @if ($u->status === 'suspended')
                                                <form action="{{ route('admin.users.suspend', $u->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" title="Activate User"
                                                        class="p-2 rounded-lg text-gray-400 hover:text-white transition-colors hover:bg-emerald-500/20 hover:text-emerald-400">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" @click="showSuspendModal = true"
                                                    title="Suspend User"
                                                    class="p-2 rounded-lg text-gray-400 hover:text-white transition-colors hover:bg-amber-500/20 hover:text-amber-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif

                                            <!-- Delete Button -->
                                            <button type="button" @click="showDeleteModal = true" title="Delete User"
                                                class="p-2 rounded-lg text-gray-400 hover:bg-red-500/20 hover:text-red-400 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Suspend Modal -->
                                            <div x-show="showSuspendModal" style="display: none;"
                                                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4">
                                                <div @click.away="showSuspendModal = false"
                                                    class="bg-[#12151a] border border-amber-900/40 rounded-2xl p-6 shadow-2xl max-w-md w-full text-left font-sans">
                                                    <div class="flex items-center gap-3 mb-4 text-amber-500">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                            </path>
                                                        </svg>
                                                        <h2 class="text-xl font-bold">Suspend {{ $u->name }}</h2>
                                                    </div>
                                                    <form action="{{ route('admin.users.suspend', $u->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-5">
                                                            <label
                                                                class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">Reason
                                                                for Suspension</label>
                                                            <textarea name="reason" required
                                                                class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-3 text-sm text-gray-300 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 resize-none whitespace-normal"
                                                                rows="3" placeholder="Explain why this user is being suspended..."></textarea>
                                                        </div>
                                                        <div class="flex justify-end gap-3 mt-6">
                                                            <button type="button" @click="showSuspendModal = false"
                                                                class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-colors">Cancel</button>
                                                            <button type="submit"
                                                                class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-5 rounded-lg text-sm transition-colors shadow-lg">Suspend</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div x-show="showDeleteModal" style="display: none;"
                                                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4">
                                                <div @click.away="showDeleteModal = false"
                                                    class="bg-[#12151a] border border-red-900/40 rounded-2xl p-6 shadow-2xl max-w-md w-full text-left font-sans">
                                                    <div class="flex items-center gap-3 mb-4 text-red-500">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                            </path>
                                                        </svg>
                                                        <h2 class="text-xl font-bold">Delete {{ $u->name }}?</h2>
                                                    </div>
                                                    <p
                                                        class="text-sm text-gray-300 mb-6 leading-relaxed whitespace-normal">
                                                        This action is irreversible. All their generated projects and data
                                                        will be removed. Please verify this action with your admin password.
                                                    </p>
                                                    <form action="{{ route('admin.users.destroy', $u->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="mb-5 relative">
                                                            <input :type="showDeletePassword ? 'text' : 'password'"
                                                                name="password" required
                                                                class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-3 pr-10 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors"
                                                                placeholder="Admin password">
                                                            <button type="button"
                                                                @click="showDeletePassword = !showDeletePassword"
                                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none">
                                                                <svg x-show="showDeletePassword" class="h-4 w-4"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" style="display: none;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                <svg x-show="!showDeletePassword" class="h-4 w-4"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.182-5.415m4.35-1.125a3 3 0 00-3.692 3.692M3 3l18 18" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="flex justify-end gap-3 mt-6">
                                                            <button type="button" @click="showDeleteModal = false"
                                                                class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-colors">Cancel</button>
                                                            <button type="submit"
                                                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-5 rounded-lg text-sm transition-colors shadow-lg">Delete
                                                                User</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No
                                        users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $users->links('pagination::tailwind') }}
                </div>

            </div>
        </div>
    </div>
@endsection
