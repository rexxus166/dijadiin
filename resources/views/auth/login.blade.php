@extends('layouts.guest')

@section('content')
    <!-- Back Button -->
    <a href="/"
        class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors mb-6">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        {{ __('Back to home') }}
    </a>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <!-- Header -->
    <div class="flex flex-col gap-2">
        <h2 class="text-3xl font-bold tracking-tight dark:text-white">Welcome Back</h2>
        <p class="text-slate-500 dark:text-slate-400">
            Sign in to continue building your next big idea.
        </p>
    </div>

    <!-- Social Login Buttons -->
    <div class="grid grid-cols-2 gap-4">
        <button type="button"
            class="flex items-center justify-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#1c1f27] px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:focus:ring-offset-[#101622]">
            <svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24">
                <path
                    d="M12.0003 20.45c-4.666 0-8.45-3.784-8.45-8.45 0-4.666 3.784-8.45 8.45-8.45 4.666 0 8.45 3.784 8.45 8.45 0 4.666-3.784 8.45-8.45 8.45z"
                    fill="white" fill-opacity="0.01"></path>
                <path
                    d="M20.25 12c0-.59-.05-1.17-.16-1.73H12v3.29h4.63c-.2 1.07-.8 1.98-1.71 2.58v2.15h2.77c1.62-1.49 2.56-3.69 2.56-6.29z"
                    fill="#4285F4"></path>
                <path
                    d="M12 20.45c2.32 0 4.27-.77 5.69-2.08l-2.77-2.15c-.77.52-1.76.82-2.92.82-2.24 0-4.14-1.51-4.81-3.55H4.28v2.23C5.7 18.57 8.66 20.45 12 20.45z"
                    fill="#34A853"></path>
                <path
                    d="M7.19 13.49c-.17-.51-.27-1.05-.27-1.61s.1-1.1.27-1.61V8.04H4.28C3.7 9.2 3.38 10.51 3.38 12s.32 2.8 4.28 3.96l2.91-2.23z"
                    fill="#FBBC05"></path>
                <path
                    d="M12 6.83c1.26 0 2.39.43 3.28 1.29l2.46-2.46C16.27 4.26 14.32 3.38 12 3.38 8.66 3.38 5.7 5.26 4.28 8.04l2.91 2.23c.67-2.03 2.57-3.54 4.81-3.54z"
                    fill="#EA4335"></path>
            </svg>
            <span>Google</span>
        </button>
        <button type="button"
            class="flex items-center justify-center gap-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#1c1f27] px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:focus:ring-offset-[#101622]">
            <svg aria-hidden="true" class="h-5 w-5 text-slate-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                <path clip-rule="evenodd"
                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                    fill-rule="evenodd"></path>
            </svg>
            <span>GitHub</span>
        </button>
    </div>

    <!-- Divider -->
    <div class="relative flex py-1 items-center">
        <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
        <span class="flex-shrink-0 mx-4 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Or
            continue with</span>
        <div class="flex-grow border-t border-slate-200 dark:border-slate-700"></div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email"
                class="text-sm font-medium leading-none text-slate-700 dark:text-slate-200">{{ __('Email Address') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="flex h-12 w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#1c1f27] px-3 pl-10 py-2 text-sm ring-offset-background placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent disabled:cursor-not-allowed disabled:opacity-50 dark:text-slate-100 transition-all"
                    placeholder="name@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password"
                    class="text-sm font-medium leading-none text-slate-700 dark:text-slate-200">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">lock</span>
                </div>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                    autocomplete="current-password"
                    class="flex h-12 w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#1c1f27] px-3 pl-10 py-2 text-sm ring-offset-background placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent disabled:cursor-not-allowed disabled:opacity-50 dark:text-slate-100 transition-all"
                    placeholder="Enter your password">
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-300">
                    <span class="material-symbols-outlined text-[20px]"
                        x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center space-x-2">
            <label for="remember_me" class="flex items-center gap-x-3 cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 bg-transparent text-primary focus:ring-primary/25 focus:ring-offset-0 focus:ring-2 dark:checked:bg-primary dark:checked:border-primary transition-all cursor-pointer">
                <span
                    class="text-sm text-slate-600 dark:text-slate-300 font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">
                    {{ __('Remember me for 30 days') }}
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="inline-flex items-center justify-center rounded-lg text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-12 w-full shadow-[0_0_20px_rgba(19,91,236,0.3)] hover:shadow-[0_0_25px_rgba(19,91,236,0.5)] transform hover:-translate-y-0.5 duration-200">
            {{ __('Sign In') }}
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