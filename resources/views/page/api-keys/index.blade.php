<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
                Gemini API Keys
            </h2>
            <a href="{{ route('project.generator.index') }}"
                class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#0a0d12] text-gray-100 px-6 py-8">

        {{-- Header --}}
        <div class="max-w-4xl mx-auto">

            {{-- Flash --}}
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

            @if($errors->any())
                <div
                    class="mb-6 flex items-center gap-3 bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-5 py-3 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Info Card --}}
            <div class="mb-8 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl px-6 py-4 flex items-start gap-4">
                <svg class="w-5 h-5 text-yellow-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-yellow-300 leading-relaxed">
                    <strong class="block mb-1">Cara Kerja API Key</strong>
                    Aktifkan satu key yang ingin dipakai. Semua request ke Gemini (Chat, Auto Scaffold) akan memakai key
                    yang aktif.
                    Jika tidak ada key yang tercatat, sistem akan menggunakan kunci cadangan dari konfigurasi server
                    (GEMINI_API_KEY di .env).
                </div>
            </div>

            {{-- Add Key Form --}}
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl p-6 mb-6">
                <h3 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah API Key Baru
                </h3>
                <form action="{{ route('api-keys.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="label" placeholder="Label (e.g. Personal Key)" value="{{ old('label') }}"
                        class="flex-1 bg-[#0d1117] border border-[#30363d] text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 placeholder-gray-600">
                    <input type="text" name="api_key" placeholder="AIzaSy..." value="{{ old('api_key') }}"
                        class="flex-[2] font-mono bg-[#0d1117] border border-[#30363d] text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 placeholder-gray-600">
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shrink-0">
                        Simpan
                    </button>
                </form>
            </div>

            {{-- Keys Table --}}
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-[#30363d]">
                    <h3 class="text-white font-bold text-lg">API Keys Tersimpan</h3>
                    <p class="text-gray-500 text-sm mt-0.5">{{ $keys->count() }} key terdaftar · hanya 1 yang aktif
                        sekaligus</p>
                </div>

                @forelse($keys as $key)
                    <div
                        class="flex items-center gap-4 px-6 py-4 border-b border-[#21262d] last:border-0 hover:bg-[#1c2128] transition-colors group">

                        {{-- Active Indicator --}}
                        <div class="shrink-0">
                            @if($key->is_active)
                                <span class="flex h-3 w-3 relative">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </span>
                            @else
                                <span class="inline-flex rounded-full h-3 w-3 bg-gray-700"></span>
                            @endif
                        </div>

                        {{-- Label + Key --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="font-semibold text-white text-sm">{{ $key->label }}</span>
                                @if($key->is_active)
                                    <span
                                        class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full font-semibold">AKTIF</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 font-mono truncate" title="{{ $key->api_key }}">
                                {{ substr($key->api_key, 0, 8) }}••••••••••••••••{{ substr($key->api_key, -4) }}
                                <span class="ml-2 text-gray-700 non-italic">Added
                                    {{ $key->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 shrink-0">
                            {{-- Activate --}}
                            @if(!$key->is_active)
                                <form action="{{ route('api-keys.activate', $key) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs px-3 py-1.5 rounded-lg bg-[#21262d] hover:bg-emerald-500/15 border border-[#30363d] hover:border-emerald-500/30 text-gray-400 hover:text-emerald-400 transition-all">
                                        Aktifkan
                                    </button>
                                </form>
                            @endif

                            {{-- Edit Toggle --}}
                            <button type="button" onclick="toggleEdit({{ $key->id }})"
                                class="text-xs px-3 py-1.5 rounded-lg bg-[#21262d] hover:bg-[#30363d] border border-[#30363d] text-gray-400 hover:text-white transition-all">
                                Edit
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('api-keys.destroy', $key) }}" method="POST"
                                onsubmit="return confirm('Hapus API Key ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs px-2 py-1.5 rounded-lg bg-[#21262d] hover:bg-red-500/15 border border-[#30363d] hover:border-red-500/30 text-gray-500 hover:text-red-400 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
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

                    {{-- Edit Form (hidden by default) --}}
                    <div id="edit-form-{{ $key->id }}" class="hidden px-6 pb-4 bg-[#1c2128]">
                        <form action="{{ route('api-keys.update', $key) }}" method="POST"
                            class="flex flex-col sm:flex-row gap-3 pt-3 border-t border-[#30363d]">
                            @csrf @method('PUT')
                            <input type="text" name="label" value="{{ $key->label }}"
                                class="flex-1 bg-[#0d1117] border border-[#30363d] text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
                            <input type="text" name="api_key" value="{{ $key->api_key }}"
                                class="flex-[2] font-mono bg-[#0d1117] border border-[#30363d] text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
                            <label class="flex items-center gap-2 text-sm text-gray-400 px-2">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ $key->is_active ? 'checked' : '' }}
                                    class="rounded border-gray-600 text-emerald-500">
                                Aktif
                            </label>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shrink-0">
                                Update
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-600">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                        <p class="text-sm">Belum ada API Key tersimpan.</p>
                        <p class="text-xs mt-1">Tambahkan key dari Google AI Studio Anda di atas.</p>
                    </div>
                @endforelse
            </div>

            {{-- Env Fallback Notice --}}
            <div class="mt-4 text-xs text-gray-600 text-center">
                Key cadangan dari .env: <code
                    class="font-mono text-gray-500">{{ env('GEMINI_API_KEY') ? substr(env('GEMINI_API_KEY'), 0, 8) . '••••••' : 'Tidak diset' }}</code>
            </div>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            const form = document.getElementById(`edit-form-${id}`);
            form.classList.toggle('hidden');
        }
    </script>
</x-app-layout>