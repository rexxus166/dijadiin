@extends('layouts.guest')

@section('full-layout')
    <!-- Main Layout -->
    <main class="flex-grow flex items-center justify-center p-4 py-12 md:p-8 lg:p-12 relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full z-0">
            <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-purple-500/5 rounded-full blur-[120px]">
            </div>
        </div>
        <div class="container max-w-[1200px] mx-auto z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Left Column: Value Proposition -->
            <div class="lg:col-span-5 flex flex-col justify-center space-y-8 lg:pr-8 py-4">
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900 dark:text-white leading-[1.1]">
                        Build Laravel Apps <span class="text-primary">Faster with AI</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 font-medium max-w-md">
                        Join thousands of developers generating production-ready code in minutes.
                    </p>
                </div>
                <!-- Feature Grid -->
                <div class="grid gap-4">
                    <!-- Feature 1 -->
                    <div
                        class="group flex items-start gap-4 p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1c1f27]/50 hover:bg-slate-50 dark:hover:bg-[#1c1f27] transition-all duration-300">
                        <div
                            class="flex-shrink-0 size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">code</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1">Full Code Ownership</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Download the source code and deploy
                                anywhere. No vendor lock-in.</p>
                        </div>
                    </div>
                    <!-- Feature 2 -->
                    <div
                        class="group flex items-start gap-4 p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1c1f27]/50 hover:bg-slate-50 dark:hover:bg-[#1c1f27] transition-all duration-300">
                        <div
                            class="flex-shrink-0 size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">layers</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1">Laravel 12 Ready</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Generates clean, modern PHP 8.3 code
                                following latest standards.</p>
                        </div>
                    </div>
                    <!-- Feature 3 -->
                    <div
                        class="group flex items-start gap-4 p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1c1f27]/50 hover:bg-slate-50 dark:hover:bg-[#1c1f27] transition-all duration-300">
                        <div
                            class="flex-shrink-0 size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">auto_fix_high</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1">No-Code Simplicity</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Describe your app in plain English and let
                                AI handle the database schema.</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial / Social Proof -->
                <div class="pt-4 flex items-center gap-3">
                    <div class="flex -space-x-3">
                        <div
                            class="size-8 rounded-full border-2 border-background-light dark:border-background-dark bg-slate-300 overflow-hidden">
                            <img alt="User avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCaqewsyFmofV5-vYRoEAqXTIIT9K-tbdx-Rx_skpwb4zVwRGciA2wv6Fl7WemqlHkuLait3Wuf7rR4HpNpFdUG_agalekw7sYmmvCj85jrKOblK6LIBNq8pCiRkRtogQggaOdGW60OB0ZG4DxseVFdMStd8mCua5YHKEUwEC71yx2tS2ku_bVbiRuj8LDwPP4KgeOchrXT_eYvWYcRRWwJxZO1MHvjkGUdhDnv_yg0LIICDfCfi1keNLHNIZnm7GgYdtxqY7jYlTE" />
                        </div>
                        <div
                            class="size-8 rounded-full border-2 border-background-light dark:border-background-dark bg-slate-300 overflow-hidden">
                            <img alt="User avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCE1Z39Lu0wz5C8A-_j_9ceAMg14aYOR3stvxuvs8aw-EmOsxOI7AP1vDJJX7HELMpZnREC97aorFa5YxK9C6qf3LPtbqw1iDdzhyjzmD4q6hZuWnAiA73NUwdMtQpDeJezvtSSTPr8oeN9k6dEU6xR6zN04R-ZsvvxpfvC6Qyuvn-JMRSBYBUEzIlQUGRSixyP95keILN_JYRqGHtG8BaBo3dSPY-tTkNxkPsZdYtTvKseV53SJkkEB2O4rnymDVUjWlLsb5TiuS0" />
                        </div>
                        <div
                            class="size-8 rounded-full border-2 border-background-light dark:border-background-dark bg-slate-300 overflow-hidden">
                            <img alt="User avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhvsbo26_2NOTCkmTcv74pt9lRZDg7oXi--l4YtxZWN2J7alZxmFxNkwoxm23iD9Gs-eQp1E32OySBfiPbihfg7Md0VxpWiJwBYNMzYw_iS4BgT8fQZJzMJAwYfDhJnsYwxZtLCre2ZD644g1g1YrNtBfJCupByoEe5ez0Y0WlSinzximZ6xB9JIHRs-32X2Z3N5UmNzS8hXj8dN6j9BGVqSQfznDyU5v9VYNkFQGvZ04lzciKUy1Tzk0Miz-YF7-K4I6_2uIBIjU" />
                        </div>
                    </div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Trusted by <span
                            class="text-slate-900 dark:text-white font-bold">1,200+</span> developers</p>
                </div>
            </div>
            <!-- Right Column: Registration Card -->
            <div class="lg:col-span-6 lg:col-start-7">
                <div
                    class="bg-white dark:bg-[#1c1f27] rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-200 dark:border-slate-800 p-8 md:p-10 h-full flex flex-col justify-center">

                    <!-- Back Button -->
                    <a href="/"
                        class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors mb-6">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        {{ __('Back to home') }}
                    </a>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ __('Create your account') }}
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400">Start your free trial. No credit card required.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Full Name -->
                        <div class="space-y-1.5">
                            <label for="name"
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('Full Name') }}</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <span class="material-symbols-outlined text-[20px]">person</span>
                                </div>
                                <input id="name" type="text" name="name" :value="old('name')" required autofocus
                                    autocomplete="name"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-[#111318] border border-slate-200 dark:border-[#3b4354] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                                    placeholder="Enter your full name" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-1.5">
                            <label for="email"
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('Email Address') }}</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <span class="material-symbols-outlined text-[20px]">mail</span>
                                </div>
                                <input id="email" type="email" name="email" :value="old('email')" required
                                    autocomplete="username"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-[#111318] border border-slate-200 dark:border-[#3b4354] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                                    placeholder="name@company.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password Group -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Password -->
                            <div class="space-y-1.5">
                                <label for="password"
                                    class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('Password') }}</label>
                                <div class="relative" x-data="{ show: false }">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                        <span class="material-symbols-outlined text-[20px]">lock</span>
                                    </div>
                                    <input id="password" :type="show ? 'text' : 'password'" name="password" required
                                        autocomplete="new-password"
                                        class="w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-[#111318] border border-slate-200 dark:border-[#3b4354] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                                        placeholder="••••••••" />
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                        <span class="material-symbols-outlined text-[20px]"
                                            x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-1.5">
                                <label for="password_confirmation"
                                    class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('Confirm Password') }}</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                        <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                                    </div>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        autocomplete="new-password"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-[#111318] border border-slate-200 dark:border-[#3b4354] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                                        placeholder="••••••••" />
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Terms & Conditions Checkbox -->
                        <div class="flex items-start gap-3 pt-2">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" required type="checkbox"
                                    class="w-4 h-4 text-primary bg-slate-50 dark:bg-[#111318] border-slate-300 dark:border-[#3b4354] rounded focus:ring-primary focus:ring-offset-0" />
                            </div>
                            <label for="terms" class="text-sm text-slate-500 dark:text-slate-400 leading-tight">
                                I agree to the <a href="#" class="text-primary hover:underline font-medium">Terms of
                                    Service</a> and <a href="#" class="text-primary hover:underline font-medium">Privacy
                                    Policy</a>.
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-blue-600 text-white font-bold py-3.5 px-6 rounded-lg shadow-lg shadow-blue-500/30 transition-all duration-200 transform hover:-translate-y-0.5 mt-2">
                            <span>{{ __('Create Account') }}</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200 dark:border-[#3b4354]"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-[#1c1f27] text-slate-500 dark:text-slate-400">Or continue
                                with</span>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button"
                            class="flex items-center justify-center gap-2 px-4 py-2.5 border border-slate-200 dark:border-[#3b4354] rounded-lg bg-slate-50 dark:bg-[#111318] hover:bg-slate-100 dark:hover:bg-[#2a2f3a] transition-colors text-sm font-medium text-slate-700 dark:text-white">
                            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 0C5.372 0 0 5.372 0 12C0 17.303 3.438 21.8 8.207 23.387C8.806 23.496 9.025 23.127 9.025 22.81C9.025 22.528 9.015 21.782 9.01 20.793C5.672 21.517 4.968 19.186 4.968 19.186C4.422 17.8 3.633 17.432 3.633 17.432C2.544 16.689 3.716 16.704 3.716 16.704C4.921 16.789 5.555 17.941 5.555 17.941C6.626 19.776 8.364 19.246 9.048 18.939C9.156 18.163 9.467 17.633 9.81 17.333C7.146 17.03 4.345 16.002 4.345 11.411C4.345 10.104 4.811 9.034 5.575 8.201C5.451 7.898 5.043 6.674 5.693 5.034C5.693 5.034 6.699 4.712 8.989 6.263C9.945 5.997 10.971 5.864 11.996 5.864C13.02 5.864 14.046 5.997 15.003 6.263C17.292 4.712 18.297 5.034 18.297 5.034C18.948 6.674 18.541 7.898 18.417 8.201C19.182 9.034 19.646 10.104 19.646 11.411C19.646 16.014 16.841 17.026 14.168 17.323C14.606 17.7 14.996 18.441 14.996 19.575C14.996 21.196 14.981 22.508 14.981 22.81C14.981 23.131 15.197 23.504 15.806 23.386C20.572 21.796 24 17.301 24 11.999C24 5.372 18.627 0 12 0Z">
                                </path>
                            </svg>
                            GitHub
                        </button>
                        <button type="button"
                            class="flex items-center justify-center gap-2 px-4 py-2.5 border border-slate-200 dark:border-[#3b4354] rounded-lg bg-slate-50 dark:bg-[#111318] hover:bg-slate-100 dark:hover:bg-[#2a2f3a] transition-colors text-sm font-medium text-slate-700 dark:text-white">
                            <svg class="size-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4"></path>
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853"></path>
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84z"
                                    fill="#FBBC05"></path>
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335"></path>
                            </svg>
                            Google
                        </button>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="font-bold text-primary hover:text-blue-500 hover:underline">Log In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection