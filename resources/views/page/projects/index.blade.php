@extends('layouts.app')

@section('content')
    <div x-data="{ search: '', sortOrder: 'desc' }" class="min-h-screen bg-[#0a0d12] text-gray-100 px-8 py-8">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">My Projects</h1>
                <p class="text-gray-500 text-sm mt-1">Manage and download your generated Laravel applications.</p>
            </div>

            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                        width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input id="search-projects" type="text" x-model="search" placeholder="Search projects..."
                        class="pl-9 pr-4 py-2 bg-[#161b22] border border-[#30363d] text-sm text-gray-300 placeholder-gray-600 rounded-lg focus:outline-none focus:border-blue-500 w-52 transition-colors">
                </div>

                {{-- API Keys Link --}}
                <a href="{{ route('api-keys.index') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-sm rounded-lg hover:bg-yellow-500/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    API Keys
                </a>

                {{-- Sort --}}
                <button @click="sortOrder = sortOrder === 'desc' ? 'asc' : 'desc'"
                    class="flex items-center gap-2 px-4 py-2 bg-[#161b22] border border-[#30363d] text-gray-400 text-sm rounded-lg hover:border-gray-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :class="sortOrder === 'asc' ? 'rotate-180 transition-transform' : 'transition-transform'">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <polyline points="19 12 12 19 5 12" />
                    </svg>
                    <span x-text="sortOrder === 'desc' ? 'Newest' : 'Oldest'">Sort</span>
                </button>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div
                class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm px-5 py-3 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ===== PROJECT GRID ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8" id="projects-grid" x-ref="grid">

            {{-- ── CREATE NEW PROJECT CARD ── --}}
            <a href="{{ route('project.generator.index') }}"
                x-show="search === ''"
                class="group border-2 border-dashed border-[#30363d] hover:border-blue-500/60 rounded-2xl p-8 flex flex-col items-center justify-center gap-4 transition-all duration-300 min-h-[260px] hover:bg-blue-500/5">
                <div
                    class="w-14 h-14 rounded-full bg-[#1c2128] group-hover:bg-blue-600 border border-[#30363d] group-hover:border-blue-500 flex items-center justify-center transition-all duration-300 shadow-lg group-hover:shadow-blue-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        class="text-gray-500 group-hover:text-white transition-colors">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-white font-bold text-lg">Create New Project</p>
                    <p class="text-gray-500 text-sm mt-1">Start a new build from scratch</p>
                </div>
            </a>

            {{-- ── PROJECT CARDS ── --}}
            @php
                // Avatar gradient pallette cycling through projects
                $gradients = [
                    'from-blue-500 to-indigo-600',
                    'from-orange-500 to-red-500',
                    'from-violet-500 to-purple-600',
                    'from-emerald-500 to-teal-600',
                    'from-pink-500 to-rose-600',
                    'from-amber-500 to-orange-500',
                ];
                $dbLabels = [
                    'mysql' => 'MySQL',
                    'pgsql' => 'PostgreSQL',
                    'sqlite' => 'SQLite',
                    'sqlsrv' => 'SQL Server',
                ];
            @endphp

            @forelse($projects as $i => $project)
                @php
                    $initials = collect(explode(' ', $project->name))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
                    $grad = $gradients[$i % count($gradients)];
                    $dbLabel = $dbLabels[$project->db_type] ?? strtoupper($project->db_type);
                @endphp

                <div class="project-card bg-[#161b22] border border-[#30363d] hover:border-[#484f58] rounded-2xl p-5 flex flex-col gap-4 transition-all duration-200 hover:shadow-2xl hover:shadow-black/30"
                    data-name="{{ strtolower($project->name) }} {{ strtolower($project->description ?? '') }}"
                    :style="sortOrder === 'asc' ? 'order: {{ $projects->count() - $i }}' : 'order: {{ $i }}'"
                    x-show="search === '' || $el.dataset.name.includes(search.toLowerCase())"
                    x-transition>

                    {{-- Card top: avatar + status --}}
                    <div class="flex items-start justify-between">
                        <div
                            class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $grad }} flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            {{ $initials ?: 'PR' }}
                        </div>
                        {{-- Status badge: default "Ready" --}}
                        <span
                            class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Ready
                        </span>
                    </div>

                    {{-- Name + description --}}
                    <div>
                        <h3 class="text-white font-bold text-lg leading-snug">{{ $project->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $project->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    {{-- Tech tags --}}
                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs text-gray-400 bg-[#0d1117] border border-[#30363d] px-3 py-1 rounded-full">Laravel
                            12</span>
                        <span
                            class="text-xs text-gray-400 bg-[#0d1117] border border-[#30363d] px-3 py-1 rounded-full">{{ $dbLabel }}</span>
                        @if($project->db_type === 'pgsql')
                            <span
                                class="text-xs text-gray-400 bg-[#0d1117] border border-[#30363d] px-3 py-1 rounded-full">Livewire</span>
                        @endif
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-[#21262d]"></div>

                    {{-- Actions --}}
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2 w-full">
                            <a href="{{ route('project.explorer.index', ['project' => $project->name]) }}"
                                class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                                Explorer
                            </a>
                            
                            <button type="button" class="preview-project-btn flex-1 flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition-colors shadow-lg shadow-emerald-600/20"
                                data-project="{{ $project->name }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Preview
                            </button>
                        </div>

                        <div class="flex items-center gap-2 w-full">
                            <a href="{{ route('project.explorer.download', ['project' => $project->name]) }}"
                                data-no-global-loading="true"
                                class="flex-1 flex items-center justify-center gap-2 bg-[#21262d] hover:bg-[#30363d] hover:text-white border border-[#30363d] text-gray-400 text-xs font-semibold py-2.5 px-3 rounded-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" y1="15" x2="12" y2="3" />
                                </svg>
                                Download ZIP
                            </a>

                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                class="shrink-0 delete-form">
                                @csrf @method('DELETE')
                                <button type="button"
                                    class="delete-project-btn w-10 h-10 flex items-center justify-center bg-[#21262d] hover:bg-red-500/15 border border-[#30363d] hover:border-red-500/30 text-gray-500 hover:text-red-400 rounded-xl transition-all"
                                    data-project-name="{{ $project->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14H6L5 6" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M9 6V4h6v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty state when no projects exist (after the create card) --}}
                <div class="md:col-span-2 flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-gray-600 text-sm">Belum ada proyek. Klik "Create New Project" untuk memulai.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($projects->hasPages())
            <div class="mb-8">
                {{ $projects->links() }}
            </div>
        @endif

        {{-- ===== STATS ROW ===== --}}
        <div class="grid grid-cols-3 gap-5">
            {{-- Total Projects --}}
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl px-6 py-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">Total Projects</p>
                    <p class="text-2xl font-bold text-white mt-0.5">{{ $projects->count() }}</p>
                </div>
            </div>

            {{-- Lines Generated (estimated) --}}
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl px-6 py-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6" />
                        <polyline points="8 6 2 12 8 18" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">Lines Generated</p>
                    @php $lines = $projects->count() * 3800;
                    $linesStr = $lines >= 1000 ? round($lines / 1000, 1) . 'k' : $lines; @endphp
                    <p class="text-2xl font-bold text-white mt-0.5">{{ $linesStr }}</p>
                </div>
            </div>

            {{-- Saved Time (estimated) --}}
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl px-6 py-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">Saved Time</p>
                    @php $hrs = $projects->count() * 11; @endphp
                    <p class="text-2xl font-bold text-white mt-0.5">~{{ $hrs }} hrs</p>
                </div>
            </div>
        </div>

    </div>


    <!-- MVP Warning Modal -->
    <div id="preview-warning-modal"
        class="fixed inset-0 z-[10000] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0 px-4">
        <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-300 border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/40 dark:to-blue-900/40 p-6 flex flex-col items-center justify-center border-b border-indigo-100 dark:border-indigo-800/60 relative">
                <div class="absolute top-3 right-3">
                    <button id="close-warning-btn" type="button" class="bg-black/5 dark:bg-white/10 hover:bg-black/10 dark:hover:bg-white/20 p-1.5 rounded-full text-gray-500 dark:text-gray-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center mb-3 border border-indigo-100 dark:border-indigo-500/30">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white text-center">Informasi Fitur Preview</h3>
            </div>
            <div class="p-6">
                <p class="text-[14px] text-gray-600 dark:text-gray-300 leading-relaxed text-center mb-6">
                    Fitur <strong>Preview Web</strong> belum didukung untuk versi MVP saat ini.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button id="cancel-preview-btn" type="button" class="flex-1 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors text-sm text-center">
                        Kembali
                    </button>
                    <button id="continue-preview-btn" type="button" class="flex-1 py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md shadow-indigo-500/30 transition-all active:scale-95 text-sm text-center">
                        Tetap Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Web Modal -->
    <div id="preview-modal" class="fixed inset-0 z-[10000] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center pointer-events-none transition-opacity duration-300 opacity-0">
        <div class="bg-gray-100 dark:bg-gray-800 w-[95%] max-w-[1400px] h-[90vh] rounded-xl shadow-2xl flex flex-col pointer-events-auto overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Modal Header -->
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center relative">
                <div class="flex items-center gap-2 pt-1 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 justify-between">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2 pb-1">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Project Preview
                    </h3>
                </div>
                
                <div class="flex-1 flex justify-center px-4 absolute left-1/2 transform -translate-x-1/2 w-1/2">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md py-1 px-3 text-sm text-gray-500 dark:text-gray-400 font-mono flex items-center gap-2 cursor-pointer shadow-sm min-w-48 max-w-full hover:bg-gray-50 dark:hover:bg-gray-700 transition" id="preview-url-box" title="Click to copy URL">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        <span id="preview-url-text" class="truncate flex-1">Starting server...</span>
                        <svg class="w-3.5 h-3.5 text-gray-400 border-l border-gray-300 dark:border-gray-600 pl-1 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="#" target="_blank" id="preview-open-new-btn" class="hidden text-sm px-3 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors flex items-center gap-1 font-medium">
                        Open in browser
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <button class="bg-red-500 hover:bg-red-600 text-white p-1 rounded transition-colors" onclick="stopAndClosePreview()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content (Iframe & Loading) -->
            <div class="flex-1 relative bg-gray-100 dark:bg-gray-800" id="preview-body">
                <!-- Loading State -->
                <div id="preview-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900/90 z-10 transition-opacity duration-500">
                    <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin mb-4"></div>
                    <div class="text-gray-700 dark:text-gray-300 font-medium animate-pulse" id="preview-loading-text">Starting server and compiling assets...</div>
                    <div class="text-xs text-gray-500 mt-2 italic">This may take a minute if it's the first time running.</div>
                </div>
                <!-- Iframe -->
                <iframe id="preview-iframe" src="about:blank" class="w-full h-full border-none opacity-0 transition-opacity duration-500" sandbox="allow-same-origin allow-scripts allow-forms allow-popups"></iframe>
            </div>
        </div>
    </div>

    {{-- Search filter JS & Preview --}}
    <script>

        // Preview Logic
        const previewModal = document.getElementById('preview-modal');
        const previewIframe = document.getElementById('preview-iframe');
        const previewLoading = document.getElementById('preview-loading');
        const previewLoadingText = document.getElementById('preview-loading-text');
        const previewUrlText = document.getElementById('preview-url-text');
        const previewOpenNewBtn = document.getElementById('preview-open-new-btn');
        const previewUrlBox = document.getElementById('preview-url-box');
        
        let activePreviewProject = null;

        // Warning Modal Logic
        const warningModal = document.getElementById('preview-warning-modal');
        const closeWarningBtn = document.getElementById('close-warning-btn');
        const cancelPreviewBtn = document.getElementById('cancel-preview-btn');
        const continuePreviewBtn = document.getElementById('continue-preview-btn');
        let pendingPreviewProject = null;

        function hideWarningModal() {
            warningModal.classList.add('opacity-0');
            warningModal.firstElementChild.classList.remove('scale-100');
            warningModal.firstElementChild.classList.add('scale-95');
            setTimeout(() => { warningModal.classList.add('hidden'); }, 300);
        }

        closeWarningBtn?.addEventListener('click', hideWarningModal);
        cancelPreviewBtn?.addEventListener('click', hideWarningModal);

        document.querySelectorAll('.preview-project-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                pendingPreviewProject = btn.dataset.project;
                warningModal.classList.remove('hidden');
                setTimeout(() => {
                    warningModal.classList.remove('opacity-0');
                    warningModal.firstElementChild.classList.remove('scale-95');
                    warningModal.firstElementChild.classList.add('scale-100');
                }, 10);
            });
        });

        continuePreviewBtn?.addEventListener('click', async () => {
            hideWarningModal();
            const project = pendingPreviewProject;
            activePreviewProject = project;

            previewModal.classList.remove('hidden');
            setTimeout(() => {
                previewModal.classList.remove('pointer-events-none', 'opacity-0');
                previewModal.firstElementChild.classList.remove('scale-95');
                previewModal.firstElementChild.classList.add('scale-100');
            }, 10);
            
            previewIframe.src = 'about:blank';
            previewIframe.classList.add('opacity-0');
            previewLoading.classList.remove('opacity-0', 'pointer-events-none');
            previewOpenNewBtn.classList.add('hidden');
            previewUrlText.textContent = "Starting server and preparing project...";
            previewLoadingText.textContent = "Starting PHP Server and compiling assets...";

                try {
                    const csrfToken = '{{ csrf_token() }}';
                    let dots = 0;
                    const loadInterval = setInterval(() => {
                        dots = (dots + 1) % 4;
                        previewUrlText.textContent = "Starting server" + ".".repeat(dots);
                    }, 500);

                    const startUrl = `/ai-builder/explorer/${project}/preview/start`;
                    const response = await fetch(startUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                    });
                    
                    clearInterval(loadInterval);

                    const result = await response.json();
                    if (result.success) {
                        previewUrlText.textContent = result.url;
                        previewOpenNewBtn.href = result.url;
                        previewOpenNewBtn.classList.remove('hidden');
                        
                        // Reload iframe dengan URL
                        previewIframe.src = result.url;
                        
                        previewIframe.onload = () => {
                            previewLoading.classList.add('opacity-0', 'pointer-events-none');
                            previewIframe.classList.remove('opacity-0');
                        };
                        
                        setTimeout(() => {
                            previewLoading.classList.add('opacity-0', 'pointer-events-none');
                            previewIframe.classList.remove('opacity-0');
                        }, 5000);
                    } else {
                        alert('Gagal start preview: ' + result.message);
                        stopAndClosePreview();
                    }
                } catch (err) {
                    console.error(err);
                    alert('Gagal request preview.');
                    stopAndClosePreview();
            }
        });

        async function stopAndClosePreview() {
            previewModal.classList.add('pointer-events-none');
            previewModal.firstElementChild.classList.remove('scale-100');
            previewModal.firstElementChild.classList.add('scale-95');
            previewModal.classList.add('opacity-0');
            
            setTimeout(() => {
                previewModal.classList.add('hidden');
                previewIframe.src = 'about:blank';
            }, 300);

            if (activePreviewProject) {
                try {
                    const csrfToken = '{{ csrf_token() }}';
                    const stopUrl = `/ai-builder/explorer/${activePreviewProject}/preview/stop`;
                    await fetch(stopUrl, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    });
                    activePreviewProject = null;
                } catch (err) {
                    console.error('Failed to stop preview', err);
                }
            }
        }
        
        previewUrlBox?.addEventListener('click', () => {
            const url = previewUrlText.textContent;
            if (url && url.startsWith('http')) {
                navigator.clipboard.writeText(url);
                const old = previewUrlText.textContent;
                previewUrlText.textContent = "Copied to clipboard!";
                setTimeout(() => {
                    if (previewUrlText.textContent === "Copied to clipboard!") {
                        previewUrlText.textContent = old;
                    }
                }, 2000);
            }
        });

        // Delete Modal Logic
        let pendingDeleteForm = null;

        function showDeleteModal(name, form) {
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalName = document.getElementById('delete-modal-name');
            pendingDeleteForm = form;
            deleteModalName.textContent = name;
            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModal.classList.remove('opacity-0');
                deleteModal.firstElementChild.classList.remove('scale-95');
                deleteModal.firstElementChild.classList.add('scale-100');
            }, 10);
        }

        function hideDeleteModal() {
            const deleteModal = document.getElementById('delete-modal');
            deleteModal.classList.add('opacity-0');
            deleteModal.firstElementChild.classList.remove('scale-100');
            deleteModal.firstElementChild.classList.add('scale-95');
            setTimeout(() => { deleteModal.classList.add('hidden'); }, 300);
            pendingDeleteForm = null;
        }

        document.querySelectorAll('.delete-project-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const name = btn.dataset.projectName;
                const form = btn.closest('.delete-form');
                showDeleteModal(name, form);
            });
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('#cancel-delete-btn') || e.target.closest('#close-delete-btn')) {
                hideDeleteModal();
            }
            if (e.target.closest('#confirm-delete-btn')) {
                if (pendingDeleteForm) pendingDeleteForm.submit();
            }
        });
    </script>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal"
        class="fixed inset-0 z-[10000] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0 px-4">
        <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl flex flex-col overflow-hidden transform scale-95 transition-transform duration-300 border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/40 dark:to-orange-900/30 p-6 flex flex-col items-center justify-center border-b border-red-100 dark:border-red-800/60 relative">
                <div class="absolute top-3 right-3">
                    <button id="close-delete-btn" type="button" class="bg-black/5 dark:bg-white/10 hover:bg-black/10 dark:hover:bg-white/20 p-1.5 rounded-full text-gray-500 dark:text-gray-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center mb-3 border border-red-100 dark:border-red-500/30">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white text-center">Hapus Project?</h3>
            </div>
            <div class="p-6">
                <p class="text-[14px] text-gray-600 dark:text-gray-300 leading-relaxed text-center mb-1">
                    Kamu yakin ingin menghapus project
                </p>
                <p class="text-[15px] font-bold text-white text-center mb-1" id="delete-modal-name"></p>
                <p class="text-[12px] text-gray-400 dark:text-gray-500 text-center mb-6">
                    Semua file dan data project ini akan dihapus secara permanen.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button id="cancel-delete-btn" type="button" class="flex-1 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors text-sm text-center">
                        Batal
                    </button>
                    <button id="confirm-delete-btn" type="button" class="flex-1 py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-md shadow-red-500/30 transition-all active:scale-95 text-sm text-center">
                        Hapus Project
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection