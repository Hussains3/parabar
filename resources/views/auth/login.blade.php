<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <div class="">
                <!-- Session Status -->
                <section class="min-h-screen flex justify-between ">
                    <div class="bg-white min-h-full min-w-4xl flex justify-center items-center p-6 px-12">

                        <div class="">
                            <div>
                                <a href="/" >
                                    <div class="flex justify-center items-center gap-2 ">
                                        <img src="{{asset('bcnf.png')}}" alt="" srcset="" class="h-[50px]">
                                        <p class="text:nblue text-2xl font-bold leading-none text-left uppercase">Parabar<br/>Shipping</p>
                                    </div>
                                </a>
                            </div>
                            <div class="w-full sm:w-7xl mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                                <x-auth-session-status class="mb-4" :status="session('status')" />

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <!-- Email Address -->
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="mt-4">
                                        <x-input-label for="password" :value="__('Password')" />

                                        <!-- Password Input with Toggle Button -->
                                        <div class="relative">
                                            <x-text-input id="password" class="block mt-1 w-full"
                                                          type="password"
                                                          name="password"
                                                          required autocomplete="current-password" />
                                            <!-- Eye Icon for Toggle -->
                                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                                                  onclick="togglePasswordVisibility()">
                                                <svg id="eye-icon" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                </svg>
                                            </span>
                                        </div>

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="block mt-4">
                                        <label for="remember_me" class="inline-flex items-center">
                                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        {{-- @if (Route::has('password.request'))
                                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif --}}

                                        <x-primary-button class="ms-3">
                                            {{ __('Log in') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="min-h-screen bg-no-repeat bg-center bg-cover flex-grow" style="background-image: url('{{ asset('images/background.jpg') }}');">
                    </div>
                </section>
        </div>

        <!-- Plugin Js -->
        <script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('js/custom.js')}}"></script>

        <!-- JavaScript for Toggle Password Visibility -->
        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');

                // Toggle the password input type
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    // Change the eye icon to "eye-off"
                    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
                } else {
                    passwordInput.type = 'password';
                    // Change the eye icon back to "eye"
                    eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />`;
                }
            }
        </script>
    </body>
</html>




