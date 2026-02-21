@extends('layouts.app')

@section('header')
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h2 class="font-bold text-xl md:text-2xl text-gray-900 dark:text-white leading-tight tracking-tight">
                Manajemen Template
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Upload dan kelola template ZIP yang bisa dipakai user.
            </p>
        </div>
        <a href="{{ route('admin.templates.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium rounded-xl shadow transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Upload Template Baru
        </a>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm px-5 py-3 rounded-xl">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="border-b border-[#30363d]">
                        <tr class="text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-5 py-3 text-left">Template</th>
                            <th class="px-5 py-3 text-left">Kategori</th>
                            <th class="px-5 py-3 text-left">Downloads</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Dibuat</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#21262d]">
                        @forelse($templates as $template)
                            <tr class="hover:bg-[#1c2128] transition-colors">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($template->thumbnail)
                                            <img src="{{ asset('storage/' . $template->thumbnail) }}"
                                                class="w-12 h-12 rounded-lg object-cover border border-[#30363d]">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-lg font-bold">
                                                {{ strtoupper(substr($template->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-white">{{ $template->name }}</p>
                                            <p class="text-gray-500 text-xs mt-0.5 line-clamp-1">
                                                {{ $template->description ?: '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="text-xs bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded-full">{{ $template->category }}</span>
                                </td>
                                <td class="px-5 py-4 text-gray-300">{{ $template->downloads }}</td>
                                <td class="px-5 py-4">
                                    @if($template->is_active)
                                        <span
                                            class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-1 rounded-full flex items-center gap-1 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>Aktif
                                        </span>
                                    @else
                                        <span
                                            class="text-xs bg-gray-500/10 text-gray-500 border border-gray-600/20 px-2 py-1 rounded-full w-fit">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-gray-500 text-xs">{{ $template->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.templates.edit', $template) }}"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-[#21262d] hover:bg-[#30363d] border border-[#30363d] text-gray-400 hover:text-white transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.templates.destroy', $template) }}" method="POST"
                                            onsubmit="return confirm('Hapus template \'{{ addslashes($template->name) }}\'?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="text-xs px-2 py-1.5 rounded-lg bg-[#21262d] hover:bg-red-500/15 border border-[#30363d] hover:border-red-500/30 text-gray-500 hover:text-red-400 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path d="M19 6l-1 14H6L5 6" />
                                                    <path d="M10 11v6" />
                                                    <path d="M14 11v6" />
                                                    <path d="M9 6V4h6v2" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center text-gray-600">
                                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                        </path>
                                    </svg>
                                    <p class="text-sm">Belum ada template. Upload template pertama Anda!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection