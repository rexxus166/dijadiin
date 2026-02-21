@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-8 min-h-screen bg-[#0f1115] dark:bg-[#0f1115]">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-100">My Projects</h1>
            <p class="text-sm text-gray-500 mt-1">Semua proyek Laravel yang sudah kamu generate.</p>
        </div>
        <a href="{{ route('project.generator.index') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shadow-lg shadow-indigo-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Buat Proyek Baru
        </a>
    </div>

    {{-- Success flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm px-5 py-3.5 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($projects->isEmpty())
        {{-- ===== EMPTY STATE ===== --}}
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-20 h-20 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"
                     stroke="#818cf8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    <line x1="12" y1="11" x2="12" y2="17"/><line x1="9" y1="14" x2="15" y2="14"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-200 mb-2">Belum ada proyek</h2>
            <p class="text-gray-500 text-sm mb-8 max-w-xs">
                Mulai buat proyek Laravel pertamamu dengan AI Builder — cukup deskripsikan idenya!
            </p>
            <a href="{{ route('project.generator.index') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-lg shadow-indigo-500/20 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
                Buat Proyek Pertama
            </a>
        </div>

    @else
        {{-- ===== PROJECT GRID ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($projects as $project)
            <div class="group bg-[#161b22] border border-gray-800 hover:border-indigo-500/40 rounded-2xl p-5 flex flex-col gap-4 transition-all duration-200 hover:shadow-xl hover:shadow-indigo-500/5">

                {{-- Card Header --}}
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-gray-100 truncate text-sm" title="{{ $project->name }}">
                                {{ $project->name }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $project->created_at->translatedFormat('d M Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- DB Type Badge --}}
                    @php
                        $dbColors = [
                            'mysql'   => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                            'pgsql'   => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            'sqlite'  => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                        ];
                        $dbColor = $dbColors[$project->db_type] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/20';
                    @endphp
                    <span class="shrink-0 text-[11px] font-semibold uppercase tracking-wide px-2.5 py-1 rounded-lg border {{ $dbColor }}">
                        {{ $project->db_type }}
                    </span>
                </div>

                {{-- Description --}}
                <p class="text-gray-400 text-sm leading-relaxed line-clamp-2 min-h-[2.5rem]">
                    {{ $project->description ?: 'Tidak ada deskripsi.' }}
                </p>

                {{-- Divider --}}
                <div class="border-t border-gray-800"></div>

                {{-- Actions --}}
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('project.explorer.index', ['project' => $project->name]) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-400 text-xs font-semibold px-3 py-2 rounded-lg border border-indigo-500/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                        </svg>
                        Open Explorer
                    </a>

                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                          onsubmit="return confirm('Hapus proyek \'{{ addslashes($project->name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-1.5 bg-red-500/5 hover:bg-red-500/15 text-red-500 text-xs font-semibold px-3 py-2 rounded-lg border border-red-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>
                                <path d="M9 6V4h6v2"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Total count --}}
        <p class="text-xs text-gray-600 text-right mt-6">
            {{ $projects->count() }} proyek
        </p>
    @endif

</div>
@endsection