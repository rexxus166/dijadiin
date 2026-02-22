@extends('layouts.guest')

@section('content')
    <!-- Back Button -->
    <a href="/"
        class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors mb-2">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        {{ __('Back to home') }}
    </a>

    <!-- Session Status -->
    <x-auth-session-status class="mb-2" :status="session('status')" />

    <!-- Header -->
    <div class="flex flex-col gap-1 mb-2">
        <h2 class="text-2xl font-bold tracking-tight dark:text-white">Welcome Back</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">
            Sign in to continue building your next big idea.
        </p>
    </div>

    <!-- Social Login Buttons -->
    <div class="grid grid-cols-2 gap-3 mt-4">
        <button type="button"
            class="flex items-center justify-center gap-1.5 px-3 py-2 border border-slate-200 dark:border-[#3b4354] rounded-lg bg-slate-50 dark:bg-[#111318] hover:bg-slate-100 dark:hover:bg-[#2a2f3a] transition-colors text-xs font-semibold text-slate-700 dark:text-white">
            <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
        <button type="button"
            class="flex items-center justify-center gap-1.5 px-3 py-2 border border-slate-200 dark:border-[#3b4354] rounded-lg bg-slate-50 dark:bg-[#111318] hover:bg-slate-100 dark:hover:bg-[#2a2f3a] transition-colors text-xs font-semibold text-slate-700 dark:text-white">
            <svg class="size-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 0C5.372 0 0 5.372 0 12C0 17.303 3.438 21.8 8.207 23.387C8.806 23.496 9.025 23.127 9.025 22.81C9.025 22.528 9.015 21.782 9.01 20.793C5.672 21.517 4.968 19.186 4.968 19.186C4.422 17.8 3.633 17.432 3.633 17.432C2.544 16.689 3.716 16.704 3.716 16.704C4.921 16.789 5.555 17.941 5.555 17.941C6.626 19.776 8.364 19.246 9.048 18.939C9.156 18.163 9.467 17.633 9.81 17.333C7.146 17.03 4.345 16.002 4.345 11.411C4.345 10.104 4.811 9.034 5.575 8.201C5.451 7.898 5.043 6.674 5.693 5.034C5.693 5.034 6.699 4.712 8.989 6.263C9.945 5.997 10.971 5.864 11.996 5.864C13.02 5.864 14.046 5.997 15.003 6.263C17.292 4.712 18.297 5.034 18.297 5.034C18.948 6.674 18.541 7.898 18.417 8.201C19.182 9.034 19.646 10.104 19.646 11.411C19.646 16.014 16.841 17.026 14.168 17.323C14.606 17.7 14.996 18.441 14.996 19.575C14.996 21.196 14.981 22.508 14.981 22.81C14.981 23.131 15.197 23.504 15.806 23.386C20.572 21.796 24 17.301 24 11.999C24 5.372 18.627 0 12 0Z">
                </path>
            </svg>
            GitHub
        </button>
    </div>

    <!-- Divider -->
    <div class="relative flex my-6 items-center">
        <div class="flex-grow border-t border-slate-100 dark:border-slate-800/60"></div>
        <span class="flex-shrink-0 mx-3 text-[11px] font-medium text-slate-500 dark:text-slate-400">Or
            continue with</span>
        <div class="flex-grow border-t border-slate-100 dark:border-slate-800/60"></div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-3.5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email"
                class="text-xs font-semibold leading-none text-slate-700 dark:text-slate-300">{{ __('Email Address') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[18px]">mail</span>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full pl-9 pr-3 py-2 bg-slate-50 dark:bg-[#111318] border border-slate-200 dark:border-[#3b4354] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                    placeholder="name@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <div class="flex items-center justify-between">
                <label for="password"
                    class="text-xs font-semibold leading-none text-slate-700 dark:text-slate-300">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-medium text-primary hover:text-primary/80 transition-colors">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[18px]">lock</span>
                </div>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                    autocomplete="current-password"
                    class="w-full pl-9 pr-9 py-2 bg-slate-50 dark:bg-[#111318] border border-slate-200 dark:border-[#3b4354] rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-sm font-medium"
                    placeholder="Enter your password">
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-2 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <span class="material-symbols-outlined text-[18px]"
                        x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2 pt-1 mt-2">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 text-primary bg-slate-50 dark:bg-[#111318] border-slate-300 dark:border-[#3b4354] rounded focus:ring-primary focus:ring-offset-0 transition-all cursor-pointer">
            <label for="remember_me"
                class="text-xs text-slate-500 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors cursor-pointer select-none">
                {{ __('Remember me for 30 days') }}
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full flex items-center justify-center gap-1.5 bg-primary hover:bg-blue-600 text-white font-bold py-2.5 px-4 rounded-lg shadow-lg shadow-blue-500/20 transition-all duration-200 mt-1">
            <span class="text-sm">{{ __('Sign In') }}</span>
        </button>
    </form>

    <!-- Footer Sign Up -->
    <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
        Don't have an account?
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary/80 transition-colors ml-1">
                {{ __('Create an account') }}
            </a>
        @endif
    </div>
@endsection