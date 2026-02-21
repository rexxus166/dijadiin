@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#0a0d12] text-gray-100 px-8 py-8">

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
                    <input id="search-projects" type="text" placeholder="Search projects..."
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
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-[#161b22] border border-[#30363d] text-gray-400 text-sm rounded-lg hover:border-gray-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="21" y1="10" x2="7" y2="10" />
                        <line x1="21" y1="6" x2="3" y2="6" />
                        <line x1="21" y1="14" x2="3" y2="14" />
                        <line x1="21" y1="18" x2="7" y2="18" />
                    </svg>
                    Sort
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
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8" id="projects-grid">

            {{-- ── CREATE NEW PROJECT CARD ── --}}
            <a href="{{ route('project.generator.index') }}"
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
                    data-name="{{ strtolower($project->name) }} {{ strtolower($project->description ?? '') }}">

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
                        <a href="{{ route('project.explorer.index', ['project' => $project->name]) }}"
                            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Buka Explorer
                        </a>

                        <div class="flex items-center gap-2 w-full">
                            <a href="{{ route('project.explorer.download', ['project' => $project->name]) }}"
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
                                onsubmit="return confirm('Hapus proyek \'{{ addslashes($project->name) }}\'?')"
                                class="shrink-0">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-10 h-10 flex items-center justify-center bg-[#21262d] hover:bg-red-500/15 border border-[#30363d] hover:border-red-500/30 text-gray-500 hover:text-red-400 rounded-xl transition-all">
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

    {{-- Search filter JS --}}
    <script>
        const searchInput = document.getElementById('search-projects');
        const cards = document.querySelectorAll('.project-card');

        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            cards.forEach(card => {
                const name = card.dataset.name || '';
                card.style.display = (!q || name.includes(q)) ? '' : 'none';
            });
        });
    </script>
@endsection