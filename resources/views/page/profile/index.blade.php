@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#0f1115] text-white py-12 px-4 sm:px-6 lg:px-8 font-sans w-full">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-bold tracking-tight mb-2 text-white">User Settings</h1>
                <p class="text-gray-400 text-sm">Manage your account information, security, and monitor your usage.</p>
            </div>

            <!-- Personal Information Section -->
            <!-- Personal Information Section -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                class="bg-[#161b22] rounded-xl border border-gray-800 overflow-hidden mb-8" x-data="{
                    showModal: false,
                    avatarPreview: '{{ $user->avatar ? asset($user->avatar) : asset('assets/avatar/avatar-1.png') }}',
                    avatarPath: '{{ $user->avatar ?? '' }}',
                
                    // State Tracking Variable
                    isDirty: false,
                
                    // Original State Values
                    originalAvatarPath: '{{ $user->avatar ?? '' }}',
                    originalName: '{{ addslashes($user->name) }}',
                    originalBio: '{{ addslashes($user->bio) }}',
                
                    checkIsDirty() {
                        const currentName = $refs.nameInput.value;
                        const currentBio = $refs.bioInput.value;
                
                        this.isDirty = (
                            this.avatarPath !== this.originalAvatarPath ||
                            currentName !== this.originalName ||
                            currentBio !== this.originalBio ||
                            $refs.avatarFileInput.files.length > 0
                        );
                    },
                
                    selectAvatar(path) {
                        this.avatarPreview = '{{ asset('') }}' + path;
                        this.avatarPath = path;
                        this.showModal = false;
                        $refs.avatarFileInput.value = '';
                        this.checkIsDirty();
                    },
                    handleFileUpload(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.avatarPreview = URL.createObjectURL(file);
                            this.avatarPath = '';
                            this.showModal = false;
                            this.checkIsDirty();
                        }
                    },
                    triggerCamera() {
                        this.showModal = false;
                        $refs.avatarFileInput.setAttribute('capture', 'environment');
                        setTimeout(() => $refs.avatarFileInput.click(), 50);
                    },
                    triggerGallery() {
                        this.showModal = false;
                        $refs.avatarFileInput.removeAttribute('capture');
                        setTimeout(() => $refs.avatarFileInput.click(), 50);
                    },
                    avatarToDelete: null,
                    showDeleteAvatarModal: false,
                    deleteAvatar(path) {
                        this.avatarToDelete = path;
                        this.showDeleteAvatarModal = true;
                    },
                    confirmDeleteAvatar() {
                        if (this.avatarToDelete) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('profile.avatar.destroy') }}';
                
                            const csrf = document.createElement('input');
                            csrf.type = 'hidden';
                            csrf.name = '_token';
                            csrf.value = '{{ csrf_token() }}';
                            form.appendChild(csrf);
                
                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';
                            form.appendChild(method);
                
                            const avatarInput = document.createElement('input');
                            avatarInput.type = 'hidden';
                            avatarInput.name = 'avatar_path';
                            avatarInput.value = this.avatarToDelete;
                            form.appendChild(avatarInput);
                
                            document.body.appendChild(form);
                            form.submit();
                        }
                    }
                }"
                x-init="checkIsDirty">
                @csrf
                @method('PATCH')

                <!-- Hidden inputs for avatar -->
                <input type="hidden" name="avatar_path" x-model="avatarPath">
                <input type="file" name="avatar_file" x-ref="avatarFileInput" class="hidden" accept="image/*"
                    @change="handleFileUpload">

                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h2 class="text-lg font-semibold text-white">Personal Information</h2>
                    </div>

                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Avatar Column -->
                        <div class="flex flex-col items-center">
                            <div class="relative mb-3 cursor-pointer group" @click="showModal = true">
                                <div
                                    class="w-28 h-28 rounded-full overflow-hidden group-hover:opacity-80 transition-opacity">
                                    <img :src="avatarPreview" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <button type="button" @click.stop="showModal = true"
                                    class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 border-4 border-[#161b22] hover:bg-blue-600 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">AVATAR
                                PROFILE</span>
                        </div>

                        <!-- Inputs Column -->
                        <div class="flex-1 space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">FULL
                                        NAME</label>
                                    <input type="text" name="name" x-ref="nameInput" @input="checkIsDirty"
                                        value="{{ old('name', $user->name) }}" required
                                        class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">EMAIL
                                        ADDRESS</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        readonly
                                        class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 text-sm text-gray-500 focus:outline-none cursor-not-allowed">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">PROFESSIONAL
                                    BIO</label>
                                <textarea name="bio" rows="3" x-ref="bioInput" @input="checkIsDirty"
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-3 text-sm text-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors resize-none leading-relaxed">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#12151a] px-6 py-4 border-t border-gray-800 flex justify-end">
                    <button type="submit" :disabled="!isDirty"
                        :class="isDirty ?
                            'bg-blue-500 hover:bg-blue-600 cursor-pointer shadow-[0_0_15px_rgba(59,130,246,0.2)]' :
                            'bg-gray-700 text-gray-400 cursor-not-allowed opacity-50'"
                        class="text-white font-medium py-2 px-[1.125rem] rounded-lg text-sm transition-colors">
                        Save Changes
                    </button>
                </div>

                <!-- Avatar Modal -->
                <div x-show="showModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"
                    @click.self="showModal = false">

                    <div class="bg-[#161b22] border border-gray-800 rounded-2xl p-6 shadow-2xl max-w-md w-full"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="flex justify-between items-center mb-5">
                            <h3 class="text-lg font-semibold text-white">Choose Avatar</h3>
                            <button type="button" @click="showModal = false"
                                class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Custom Avatars Section if any -->
                        @if (!empty($user->custom_avatars))
                            <div class="mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 mb-3 uppercase tracking-wider">Your Custom
                                    Avatars</h4>
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($user->custom_avatars as $index => $customAvatar)
                                        <div
                                            class="relative cursor-pointer group flex flex-col items-center gap-1.5 shrink-0">
                                            <div @click="selectAvatar('{{ $customAvatar }}')"
                                                class="w-14 h-14 rounded-full border-2 border-transparent group-hover:border-blue-500 overflow-hidden transition-all bg-[#0d1015]">
                                                <img src="{{ asset($customAvatar) }}" class="w-full h-full object-cover">
                                            </div>
                                            <button type="button" @click.stop="deleteAvatar('{{ $customAvatar }}')"
                                                class="absolute top-0 right-1 bg-red-500 rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600 shadow-lg"
                                                title="Delete Avatar">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="border-t border-gray-800 pt-4 mb-4">
                                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Default & Upload
                                </h4>
                            </div>
                        @endif

                        <div class="flex items-center justify-between gap-2">
                            <!-- Avatar 1 -->
                            <div @click="selectAvatar('assets/avatar/avatar-1.png')"
                                class="cursor-pointer group flex flex-col items-center gap-2">
                                <div
                                    class="w-20 h-20 rounded-full border-2 border-transparent group-hover:border-blue-500 overflow-hidden transition-all bg-orange-300">
                                    <img src="{{ asset('assets/avatar/avatar-1.png') }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <span class="text-xs text-gray-400 group-hover:text-blue-400">Avatar 1</span>
                            </div>

                            <!-- Avatar 2 -->
                            <div @click="selectAvatar('assets/avatar/avatar-2.png')"
                                class="cursor-pointer group flex flex-col items-center gap-2">
                                <div
                                    class="w-20 h-20 rounded-full border-2 border-transparent group-hover:border-blue-500 overflow-hidden transition-all bg-emerald-300">
                                    <img src="{{ asset('assets/avatar/avatar-2.png') }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <span class="text-xs text-gray-400 group-hover:text-blue-400">Avatar 2</span>
                            </div>

                            <!-- Upload from Gallery -->
                            <div @click="triggerGallery()" class="cursor-pointer group flex flex-col items-center gap-2">
                                <div
                                    class="w-20 h-20 rounded-full border-2 border-gray-700 bg-[#0d1015] group-hover:border-blue-500 flex items-center justify-center transition-all">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-400 group-hover:text-blue-400">Gallery</span>
                            </div>

                            <!-- Capture Camera -->
                            <div @click="triggerCamera()" class="cursor-pointer group flex flex-col items-center gap-2">
                                <div
                                    class="w-20 h-20 rounded-full border-2 border-gray-700 bg-[#0d1015] group-hover:border-blue-500 flex items-center justify-center transition-all">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-400 group-hover:text-blue-400">Camera</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Avatar Confirmation Modal -->
                <div x-show="showDeleteAvatarModal"
                    class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"
                    @click.self="showDeleteAvatarModal = false" x-cloak>

                    <div class="relative bg-[#161b22] border border-gray-800 rounded-2xl p-6 shadow-2xl max-w-sm w-full text-center"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <!-- Close button -->
                        <button type="button" @click="showDeleteAvatarModal = false"
                            class="absolute top-4 right-4 text-gray-500 hover:text-white bg-[#0d1015] hover:bg-gray-800 rounded-full p-1.5 transition-colors cursor-pointer border border-[#30363d]">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div
                            class="w-14 h-14 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center mx-auto mb-4 text-red-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Hapus Avatar Custom?</h3>
                        <p class="text-sm text-gray-400 mb-6 px-2">Anda yakin ingin menghapus avatar custom ini? Tindakan
                            ini tidak dapat diurungkan atau dibatalkan.</p>

                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <button type="button" @click="showDeleteAvatarModal = false"
                                class="flex-1 py-2.5 px-4 bg-[#0d1015] hover:bg-[#1a202c] border border-gray-800 text-gray-300 rounded-xl font-medium text-sm transition-colors cursor-pointer">Batal</button>
                            <button type="button" @click="confirmDeleteAvatar()"
                                class="flex-1 py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white border border-red-500 rounded-xl font-medium text-sm shadow-lg shadow-red-600/20 transition-all cursor-pointer">Ya,
                                Hapus</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- Account Security Section -->
            <div class="bg-[#161b22] rounded-xl border border-gray-800 overflow-hidden mb-8" x-data="{ showNewPassword: false, showConfirmPassword: false }">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <h2 class="text-lg font-semibold text-white">Account Security</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">CURRENT
                                PASSWORD</label>
                            <input type="password"
                                class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 text-sm text-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors placeholder-gray-600"
                                placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">NEW
                                PASSWORD</label>
                            <div class="relative">
                                <input :type="showNewPassword ? 'text' : 'password'"
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 pr-10 text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors placeholder-gray-600"
                                    placeholder="8+ characters">
                                <button type="button" @click="showNewPassword = !showNewPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none">
                                    <svg x-show="showNewPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!showNewPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.182-5.415m4.35-1.125a3 3 0 00-3.692 3.692M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 mb-2 uppercase tracking-wider">CONFIRM
                                NEW PASSWORD</label>
                            <div class="relative">
                                <input :type="showConfirmPassword ? 'text' : 'password'"
                                    class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-2.5 pr-10 text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors placeholder-gray-600"
                                    placeholder="Match new password">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none">
                                    <svg x-show="showConfirmPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!showConfirmPassword" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.182-5.415m4.35-1.125a3 3 0 00-3.692 3.692M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#12151a] px-6 py-4 border-t border-gray-800 flex justify-between items-center">
                    <span class="text-xs text-gray-500">Last updated: 3 months ago</span>
                    <button
                        class="bg-[#2d3748] hover:bg-[#3a4459] text-gray-100 font-medium py-2 px-5 rounded-lg text-sm transition-colors border border-gray-700">
                        Update Password
                    </button>
                </div>
            </div>

            @if (auth()->user()->role !== 'admin')
                <!-- Usage Stats Section -->
                <div class="bg-[#161b22] rounded-xl border border-gray-800 p-6 mb-8">
                    <div class="flex items-center mb-6">
                        <!-- Chart icon matching the image -->
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                        <h2 class="text-lg font-semibold text-white">Usage Stats</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 relative">
                        <!-- Stat Card 1 -->
                        <div class="bg-[#0d1015] border border-gray-800 rounded-xl p-6 flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">TOTAL
                                        PROJECTS
                                        BUILT</span>
                                    <div class="text-[32px] font-bold mt-1 text-white leading-none">
                                        {{ $user->generatedProjects()->count() }}</div>
                                </div>
                                <div class="bg-[#161b22] p-2.5 rounded-lg border border-gray-800">
                                    <!-- Box Icon -->
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <a href="#"
                                class="text-[11px] text-blue-500 font-bold hover:text-blue-400 uppercase flex items-center mt-2 tracking-widest mt-auto">
                                VIEW ALL PROJECTS <span class="ml-1.5 text-sm leading-none">&rarr;</span>
                            </a>
                        </div>

                        <!-- Stat Card 2 -->
                        <div class="bg-[#0d1015] border border-gray-800 rounded-xl p-6 flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    @php
                                        // Simple quota metric
                                        $aiUsage = $user->generatedProjects()->whereNotNull('ai_prompt')->count();
                                        $aiQuota = 100; // Let's pretend 100 is the limit for now
                                        $aiPercentage = $aiUsage > 0 ? min(round(($aiUsage / $aiQuota) * 100), 100) : 0;
                                    @endphp
                                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">AI PROJECTS
                                        GENERATED</span>
                                    <div class="text-[32px] font-bold mt-1 flex items-baseline text-white leading-none">
                                        {{ $aiUsage }} <span
                                            class="text-sm font-normal text-gray-500 ml-1.5 align-baseline">/
                                            {{ $aiQuota }}</span>
                                    </div>
                                </div>
                                <div class="bg-[#161b22] p-2.5 rounded-lg border border-gray-800 gap-2">
                                    <!-- Lightning Icon -->
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div class="w-full bg-[#1e2532] rounded-full h-1.5 mb-2 overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: {{ $aiPercentage }}%">
                                    </div>
                                </div>
                                <div class="text-[9px] text-gray-500 font-bold text-right uppercase tracking-[0.15em]">
                                    {{ $aiPercentage }}% OF MONTHLY QUOTA CONSUMED
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div x-data="{ showDeleteModal: false, showDeletePassword: false }">
                    <div
                        class="bg-[#160e10] rounded-xl border border-red-900/40 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-red-500 mb-1">Danger Zone</h2>
                            <p class="text-sm text-gray-400">Permanently delete your account and all associated projects.
                                This
                                action cannot be undone.</p>
                        </div>
                        <button type="button" @click="showDeleteModal = true"
                            class="bg-[#e53e3e] hover:bg-red-700 text-white font-medium py-2 pb-2.5 px-6 rounded-lg text-sm shrink-0 transition-colors flex flex-col items-center justify-center leading-tight shadow-[0_0_15px_rgba(229,62,62,0.15)] h-auto">
                            <span>Delete</span>
                            <span>Account</span>
                        </button>
                    </div>

                    <!-- Delete Account Modal -->
                    <div x-show="showDeleteModal" style="display: none;"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                        <div class="bg-[#12151a] border border-red-900/40 rounded-2xl p-6 shadow-2xl max-w-md w-full"
                            @click.away="showDeleteModal = false" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                            <div class="flex items-center gap-3 mb-4 text-red-500">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h2 class="text-xl font-bold">Delete Account</h2>
                            </div>

                            <p class="text-sm text-gray-300 mb-6 leading-relaxed">
                                Once your account is deleted, all of its resources and data will be permanently deleted.
                                Please
                                enter your password to confirm you would like to permanently delete your account.
                            </p>

                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')

                                <div class="mb-6 relative">
                                    <input :type="showDeletePassword ? 'text' : 'password'" name="password" required
                                        class="w-full bg-[#0d1015] border border-gray-800 rounded-lg px-4 py-3 pr-10 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors placeholder-gray-600"
                                        placeholder="Enter your password">

                                    <button type="button" @click="showDeletePassword = !showDeletePassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-200 focus:outline-none">
                                        <svg x-show="showDeletePassword" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="!showDeletePassword" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.182-5.415m4.35-1.125a3 3 0 00-3.692 3.692M3 3l18 18" />
                                        </svg>
                                    </button>

                                    @if ($errors->userDeletion->has('password'))
                                        <span class="text-xs text-red-500 font-medium mt-2 block">
                                            {{ $errors->userDeletion->first('password') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-end gap-3 mt-6">
                                    <button type="button" @click="showDeleteModal = false"
                                        class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-5 rounded-lg text-sm transition-colors shadow-lg">
                                        Delete Account
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <div
                class="mt-14 pb-8 pt-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between text-[11px] text-gray-500 tracking-wide font-medium">
                <div class="mb-4 sm:mb-0">
                    &copy; {{ date('Y') }} DIJADIIN + AI-Powered Laravel Engine
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-gray-300 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-gray-300 transition-colors">Terms</a>
                    <a href="#" class="hover:text-gray-300 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </div>
@endsection
