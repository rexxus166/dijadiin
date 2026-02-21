@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.templates.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h2 class="font-bold text-xl text-gray-900 dark:text-white">Upload Template Baru</h2>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#161b22] border border-[#30363d] rounded-2xl p-8">
                @if($errors->any())
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Nama Template <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500"
                            placeholder="e.g. Toko Online UMKM">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Kategori <span
                                class="text-red-400">*</span></label>
                        <select name="category" required
                            class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500">
                            <option value="umum" {{ old('category') == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="umkm" {{ old('category') == 'umkm' ? 'selected' : '' }}>UMKM / Bisnis Kecil
                            </option>
                            <option value="jual_beli" {{ old('category') == 'jual_beli' ? 'selected' : '' }}>Jual Beli /
                                E-Commerce</option>
                            <option value="blog" {{ old('category') == 'blog' ? 'selected' : '' }}>Blog / Artikel</option>
                            <option value="portofolio" {{ old('category') == 'portofolio' ? 'selected' : '' }}>Portofolio
                            </option>
                            <option value="landing_page" {{ old('category') == 'landing_page' ? 'selected' : '' }}>Landing
                                Page</option>
                            <option value="sekolah" {{ old('category') == 'sekolah' ? 'selected' : '' }}>Sekolah / Pendidikan
                            </option>
                            <option value="resto" {{ old('category') == 'resto' ? 'selected' : '' }}>Restoran / F&B</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500"
                            placeholder="Jelaskan fitur-fitur dalam template ini...">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">File ZIP Template <span
                                class="text-red-400">*</span></label>
                        <input type="file" name="zip_file" accept=".zip" required
                            class="w-full bg-[#0d1117] border border-[#30363d] text-gray-400 rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-500">
                        <p class="text-xs text-gray-600 mt-1">Maks. 50MB. ZIP harus berisi folder project Laravel.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Thumbnail (Opsional)</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full bg-[#0d1117] border border-[#30363d] text-gray-400 rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                        <p class="text-xs text-gray-600 mt-1">PNG/JPG, maks. 2MB. Rasio 16:9 direkomendasikan.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" id="is_active" checked
                            class="rounded border-gray-600 text-emerald-500 focus:ring-emerald-500">
                        <label for="is_active" class="text-sm text-gray-300">Aktifkan template (tampilkan ke user)</label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3 rounded-xl transition-colors">
                            Upload & Simpan Template
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection