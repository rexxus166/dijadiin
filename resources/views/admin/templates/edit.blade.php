@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.templates.index') }}" class="text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-xl text-gray-900 dark:text-white">Edit Template: {{ $template->name }}</h2>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-[#161b22] border border-[#30363d] rounded-2xl p-8">
            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.templates.update', $template) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nama Template</label>
                    <input type="text" name="name" value="{{ old('name', $template->name) }}" required
                        class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Kategori</label>
                    <select name="category" class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
                        @foreach(['umum','umkm','jual_beli','blog','portofolio','landing_page','sekolah','resto'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $template->category) === $cat ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">{{ old('description', $template->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Ganti File ZIP (opsional)</label>
                    <p class="text-xs text-gray-600 mb-1">Saat ini: <code class="text-gray-400">{{ basename($template->zip_path) }}</code></p>
                    <input type="file" name="zip_file" accept=".zip"
                        class="w-full bg-[#0d1117] border border-[#30363d] text-gray-400 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-600 file:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Ganti Thumbnail (opsional)</label>
                    @if($template->thumbnail)
                        <img src="{{ asset('storage/' . $template->thumbnail) }}" class="w-32 h-20 object-cover rounded-lg border border-[#30363d] mb-2">
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full bg-[#0d1117] border border-[#30363d] text-gray-400 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white">
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ $template->is_active ? 'checked' : '' }}
                        class="rounded border-gray-600 text-emerald-500 focus:ring-emerald-500">
                    <label for="is_active" class="text-sm text-gray-300">Template aktif</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-xl transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
