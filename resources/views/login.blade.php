@extends('auth.layouts.default')

@section('content')
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-branding.logo/>
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('Sign in to your account') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        {{ __('Dont have an account?') }}
                        <a href="{{ route('register') }}" class="font-semibold text-teal-600 hover:text-teal-500">{{ __('Register') }}</a>
                    </p>
                </div>

                <div class="mt-10">
                    <div>
                        <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                            @csrf
                            @honeypot

                            <div>
                                <label for="email-address"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                    value="{{ old('email') }}"
                                >
                                    {{ __('Email Address') }}
                                </label>
                                <div class="mt-2">
                                    <input
                                        dusk="email" id="email-address" name="email" type="email" autocomplete="email"
                                        class="focus:shadow-none block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6"
                                        required
                                    >
                                </div>
                                @error('email')
                                <span class="text-sm text-red-500">{{$message}}</span>
                                @enderror
                            </div>

                            <div x-data="{ showPassword: false }">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                                    {{ __('Password') }}
                                </label>

                                <div class="relative mt-2 flex items-center">
                                    <input dusk="password" id="password" name="password" autocomplete="current-password"
                                           :type="showPassword ? 'text' : 'password'"
                                           class="focus:shadow-none block w-full rounded-md border-0 py-1.5 pr-10 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6"
                                           required
                                    >
                                    <div x-on:click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                        <div class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">
                                            <svg x-show="!showPassword" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
                                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <svg x-show="showPassword" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z"/>
                                                <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z"/>
                                                <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z"/>
                                            </svg>

                                        </div>
                                    </div>
                                </div>

                                @error('password')
                                <span class="text-sm text-red-500">{{$message}}</span>
                                @enderror
                            </div>


                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="focus:shadow-none h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-600">
                                    <label for="remember" class="ml-3 block text-sm leading-6 text-gray-700">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                <div class="text-sm leading-6">
                                    <a href="{{ route('request-password') }}"
                                       class="font-semibold text-teal-600 hover:text-teal-500">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>

                            <div>
                                <button dusk="login-button" type="submit" class="flex w-full justify-center rounded-md bg-teal-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                    {{ __('Sign In') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://res.cloudinary.com/codebar/image/upload/f_auto//www-thejungledog-eco/pexels-mikhail-nilov-8412432.jpg" alt="Pexels Mikhail Nilov 8412432" title="Pexels Mikhail Nilov 8412432">
        </div>
    </div>

@endsection
