@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h2 class="font-bold text-xl md:text-2xl text-gray-900 dark:text-white leading-tight tracking-tight">
                Statistics Overview
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Real-time platform metrics and user activity analysis.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-4">
            <div
                class="flex items-center bg-gray-100 dark:bg-[#1a1f28] rounded-xl p-1 border border-gray-200 dark:border-gray-800/80 shadow-sm">
                <button
                    class="px-4 py-1.5 text-sm font-medium rounded-lg bg-white dark:bg-[#2a303c] text-gray-900 dark:text-gray-100 shadow-sm transition-colors">Today</button>
                <button
                    class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-200 dark:hover:bg-[#2a303c] transition-colors">Week</button>
                <button
                    class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-200 dark:hover:bg-[#2a303c] transition-colors">Month</button>
            </div>

            <button
                class="flex items-center gap-2 px-4 py-2 bg-[#3b82f6] hover:bg-blue-600 text-white text-sm font-medium rounded-xl shadow-sm transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4M12 4v12m0 0l-4-4m4 4l4-4"></path>
                </svg>
                Export Report
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Card 1 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="p-2.5 rounded-xl bg-gray-50 dark:bg-[#1f2532] text-gray-500 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="flex items-center gap-1 text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +12%
                        </div>
                    </div>
                    <div class="mt-2 text-left">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalUsers) }}
                        </p>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1 rounded-full mt-6 overflow-hidden">
                        <div class="bg-[#10b981] h-full rounded-full" style="width: 70%"></div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="p-2.5 rounded-xl bg-gray-50 dark:bg-[#1f2532] text-gray-500 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 10.5L21 3v6l-7.5 7.5L9 21l-3-3L1.5 15l7.5-3.5z"></path>
                            </svg>
                        </div>
                        <div
                            class="flex items-center gap-1 text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +5%
                        </div>
                    </div>
                    <div class="mt-2 text-left">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalProjects) }}
                        </p>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full mt-6 overflow-hidden">
                        <div class="bg-[#3b82f6] h-full rounded-full" style="width: 55%"></div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-1/2 -translate-y-1/2 opacity-5 dark:opacity-10 pointer-events-none transform group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 2a5 5 0 0 0-5 5v2a5 5 0 0 0-1.5 9.77V22h13v-3.23A5 5 0 0 0 17 9V7a5 5 0 0 0-5-5z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex justify-between items-start mb-4 relative">
                        <div
                            class="p-2.5 rounded-xl bg-gray-50 dark:bg-[#1f2532] text-gray-500 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div
                            class="flex items-center gap-1.5 text-[10px] font-bold text-blue-500 dark:text-[#3b82f6] bg-blue-50 dark:bg-[#3b82f6]/10 px-2 py-1 rounded-md uppercase tracking-wider border border-blue-100 dark:border-[#3b82f6]/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#3b82f6] animate-pulse hidden sm:block"></span>
                            LIVE
                        </div>
                    </div>
                    <div class="mt-2 relative text-left">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Active AI Sessions</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">42</p>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full mt-6 overflow-hidden relative">
                        <div class="bg-[#3b82f6] h-full rounded-full w-1/3"></div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-white dark:bg-[#161b22] rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="p-2.5 rounded-xl bg-gray-50 dark:bg-[#1f2532] text-gray-500 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </div>
                        <div
                            class="flex items-center gap-1 text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +8%
                        </div>
                    </div>
                    <div class="mt-2 text-left">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Downloads (ZIP)</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">5,100</p>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full mt-6 overflow-hidden">
                        <div class="bg-purple-500 h-full rounded-full" style="width: 45%"></div>
                    </div>
                </div>

            </div>

            <!-- Middle Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Chart Card -->
                <div
                    class="bg-white dark:bg-[#161b22] border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm lg:col-span-2 relative">
                    <div class="flex justify-between items-start mb-6">
                        <div class="text-left">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Project Generation Trends</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monthly generation volume</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#3b82f6]"></span>
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Current Month</span>
                        </div>
                    </div>

                    <div class="relative h-[250px] w-full mt-4">
                        <svg viewBox="0 0 800 250" class="w-full h-full" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0"
                                    y2="1">
                                    <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.25"></stop>
                                    <stop offset="100%" stop-color="#3b82f6" stop-opacity="0"></stop>
                                </linearGradient>
                            </defs>

                            <g class="text-[#4b5563] text-xs font-medium" fill="currentColor">
                                <line x1="40" y1="20" x2="800" y2="20" stroke="currentColor"
                                    stroke-opacity="0.1" stroke-width="1"></line>
                                <text x="30" y="24" text-anchor="end">10k</text>
                                <line x1="40" y1="70" x2="800" y2="70" stroke="currentColor"
                                    stroke-opacity="0.1" stroke-width="1"></line>
                                <text x="30" y="74" text-anchor="end">7.5k</text>
                                <line x1="40" y1="120" x2="800" y2="120" stroke="currentColor"
                                    stroke-opacity="0.1" stroke-width="1"></line>
                                <text x="30" y="124" text-anchor="end">5k</text>
                                <line x1="40" y1="170" x2="800" y2="170" stroke="currentColor"
                                    stroke-opacity="0.1" stroke-width="1"></line>
                                <text x="30" y="174" text-anchor="end">2.5k</text>
                                <line x1="40" y1="220" x2="800" y2="220" stroke="currentColor"
                                    stroke-opacity="0.1" stroke-width="1"></line>
                                <text x="30" y="224" text-anchor="end">0</text>

                                <text x="80" y="242" text-anchor="middle">Mon</text>
                                <text x="200" y="242" text-anchor="middle">Tue</text>
                                <text x="320" y="242" text-anchor="middle">Wed</text>
                                <text x="440" y="242" text-anchor="middle">Thu</text>
                                <text x="560" y="242" text-anchor="middle">Fri</text>
                                <text x="680" y="242" text-anchor="middle">Sat</text>
                                <text x="780" y="242" text-anchor="middle">Sun</text>
                            </g>

                            <path
                                d="M40 200 C100 150, 140 160, 180 150 C230 140, 260 80, 320 90 C360 100, 380 90, 440 60 C480 40, 500 40, 560 30 C610 20, 640 40, 680 25 C720 10, 750 15, 800 -10 L800 220 L40 220 Z"
                                fill="url(#chartGradient)"></path>
                            <path
                                d="M40 200 C100 150, 140 160, 180 150 C230 140, 260 80, 320 90 C360 100, 380 90, 440 60 C480 40, 500 40, 560 30 C610 20, 640 40, 680 25 C720 10, 750 15, 800 -10"
                                fill="none" class="stroke-[#3b82f6]" stroke-width="2.5" stroke-linecap="round">
                            </path>

                            <circle cx="180" cy="150" r="4.5" fill="#161b22" class="stroke-[#3b82f6]"
                                stroke-width="2.5"></circle>
                            <circle cx="320" cy="90" r="4.5" fill="#161b22" class="stroke-[#3b82f6]"
                                stroke-width="2.5"></circle>
                            <circle cx="440" cy="60" r="4.5" fill="#161b22" class="stroke-[#3b82f6]"
                                stroke-width="2.5"></circle>
                            <circle cx="680" cy="25" r="4.5" fill="#161b22" class="stroke-[#3b82f6]"
                                stroke-width="2.5"></circle>
                        </svg>
                    </div>
                </div>

                <!-- Popular Categories -->
                <div
                    class="bg-white dark:bg-[#161b22] border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm flex flex-col">
                    <div class="mb-6 text-left">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Popular Categories</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Top 5 All Time</p>
                    </div>
                    <div class="space-y-6 flex-1 mt-2">

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Inventory</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">45%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#3b82f6] h-full rounded-full" style="width: 45%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">POS System</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">32%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#3b82f6] h-full rounded-full" style="width: 32%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Blog Platform</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">28%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#3b82f6] h-full rounded-full" style="width: 28%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">CRM</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">15%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#3b82f6] h-full rounded-full" style="width: 15%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Landing Page</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">10%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800/80 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#3b82f6] h-full rounded-full" style="width: 10%;"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Recent Project Requests -->
            <div
                class="bg-white dark:bg-[#161b22] border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden mt-6">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Project Requests</h3>
                    <a href="#"
                        class="text-[#3b82f6] hover:text-blue-500 text-sm font-medium transition-colors">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead
                            class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase bg-gray-50/50 dark:bg-transparent border-b border-gray-100 dark:border-gray-800 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">PROJECT NAME</th>
                                <th class="px-6 py-4">CATEGORY</th>
                                <th class="px-6 py-4">USER</th>
                                <th class="px-6 py-4">STATUS</th>
                                <th class="px-6 py-4 text-right">DATE</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                            @forelse($recentProjects as $project)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-colors group">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $project->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-100 dark:bg-[#1f2838] text-gray-600 dark:text-[#6e8fd4] uppercase">
                                            {{ $project->db_type ?? 'Generic' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($project->user)
                                                <img src="{{ $project->user->avatar ? asset($project->user->avatar) : asset('assets/avatar/avatar-1.png') }}"
                                                    class="w-7 h-7 rounded-full object-cover border border-gray-200 dark:border-gray-700"
                                                    alt="{{ $project->user->name }}">
                                                <span
                                                    class="font-medium text-gray-900 dark:text-gray-400">{{ $project->user->name }}</span>
                                            @else
                                                <div
                                                    class="w-7 h-7 rounded-full bg-gray-200 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-xs text-gray-500">
                                                    ?</div>
                                                <span class="font-medium text-gray-900 dark:text-gray-400">Unknown
                                                    User</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center gap-2 text-[#10b981] dark:text-[#10b981] font-medium">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-[#10b981] shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span>
                                            Completed
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-500 dark:text-gray-500">
                                        {{ $project->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No
                                        project requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
