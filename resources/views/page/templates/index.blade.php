@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0a0d12] text-gray-100 px-6 py-8">

    {{-- Header --}}
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-lg shadow-lg shadow-purple-500/30">✦</span>
                    Template Marketplace
                </h1>
                <p class="text-gray-500 text-sm mt-2">Mulai cepat dengan template siap pakai. Download & edit sesuka hati di Explorer.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-white flex items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                My Projects
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">

        {{-- Flash --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm px-5 py-3 rounded-xl">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route('templates.index') }}" class="flex flex-wrap items-center gap-3 mb-8">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari template..."
                    class="w-full pl-9 pr-4 py-2 bg-[#161b22] border border-[#30363d] text-sm text-gray-300 placeholder-gray-600 rounded-lg focus:outline-none focus:border-purple-500">
            </div>
            <div class="flex flex-wrap gap-2">
                @php $currentCat = request('category', 'semua'); @endphp
                <a href="{{ route('templates.index') }}"
                    class="px-4 py-2 text-sm rounded-lg border transition-all {{ $currentCat === 'semua' ? 'bg-purple-600 border-purple-500 text-white' : 'bg-[#161b22] border-[#30363d] text-gray-400 hover:border-gray-500' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('templates.index', ['category' => $cat]) }}"
                        class="px-4 py-2 text-sm rounded-lg border transition-all {{ $currentCat === $cat ? 'bg-purple-600 border-purple-500 text-white' : 'bg-[#161b22] border-[#30363d] text-gray-400 hover:border-gray-500' }}">
                        {{ ucwords(str_replace('_', ' ', $cat)) }}
                    </a>
                @endforeach
            </div>
        </form>

        {{-- Template Grid --}}
        @if($templates->isEmpty())
            <div class="text-center py-24 text-gray-600">
                <p class="text-5xl mb-4">📦</p>
                <p class="text-lg font-semibold text-gray-500">Belum ada template tersedia.</p>
                <p class="text-sm mt-1">Pantau terus, admin sedang menyiapkan template-template terbaik!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($templates as $template)
                    <div class="bg-[#161b22] border border-[#30363d] hover:border-purple-500/40 rounded-2xl overflow-hidden flex flex-col transition-all duration-200 hover:shadow-xl hover:shadow-purple-900/20 group">

                        {{-- Thumbnail --}}
                        <div class="relative aspect-video bg-[#0d1117] overflow-hidden">
                            @if($template->thumbnail)
                                <img src="{{ asset('storage/' . $template->thumbnail) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900/50 to-purple-900/50">
                                    <span class="text-5xl opacity-40">🗂️</span>
                                </div>
                            @endif
                            {{-- Category badge --}}
                            <span class="absolute top-2 left-2 text-xs bg-black/60 backdrop-blur-sm text-purple-300 border border-purple-500/20 px-2 py-0.5 rounded-full">
                                {{ ucwords(str_replace('_', ' ', $template->category)) }}
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-white text-sm leading-snug">{{ $template->name }}</h3>
                            <p class="text-gray-500 text-xs mt-1 line-clamp-2 flex-1">{{ $template->description ?: 'Template siap pakai.' }}</p>

                            <div class="flex items-center gap-1 mt-3 text-gray-600 text-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                {{ $template->downloads }} kali dipakai
                            </div>

                            {{-- Use Button --}}
                            <button type="button"
                                onclick="openUseModal({{ $template->id }}, '{{ addslashes($template->name) }}')"
                                class="mt-4 w-full bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors shadow-lg shadow-purple-600/20 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Gunakan Template
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Use Template Modal --}}
<div id="use-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-700 rounded-2xl w-full max-w-md p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-white mb-1" id="modal-title">Gunakan Template</h3>
        <p class="text-gray-400 text-sm mb-5">Template akan di-extract ke folder project baru milik Anda.</p>

        <form id="use-template-form" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-1">Nama Project Baru <span class="text-red-400">*</span></label>
                <input type="text" name="project_name" id="modal-project-name"
                    placeholder="e.g. toko-baju-saya"
                    pattern="^[a-z0-9\-\_]+$"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-purple-500 font-mono"
                    required>
                <p class="text-xs text-gray-600 mt-1">Hanya huruf kecil, angka, tanda hubung, dan underscore.</p>

                @if($errors->has('project_name'))
                    <p class="text-red-400 text-xs mt-1">{{ $errors->first('project_name') }}</p>
                @endif
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeUseModal()"
                    class="flex-1 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-lg shadow-purple-600/20 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Buat Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const routes = @json([
        'base' => rtrim(route('templates.index'), '/')
    ]);

    function openUseModal(templateId, templateName) {
        document.getElementById('modal-title').textContent = 'Gunakan: ' + templateName;
        document.getElementById('use-template-form').action = routes.base + '/' + templateId + '/use';
        document.getElementById('modal-project-name').value = '';
        document.getElementById('use-modal').classList.remove('hidden');
        setTimeout(() => document.getElementById('modal-project-name').focus(), 100);
    }

    function closeUseModal() {
        document.getElementById('use-modal').classList.add('hidden');
    }

    document.getElementById('use-modal').addEventListener('click', function(e) {
        if (e.target === this) closeUseModal();
    });
</script>
@endsection
