<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('vendor/auth/app.css') }}">

    <title>{{ config('app.name') }}</title>
</head>

<body class="font-sans antialiased h-full">

<main>
    <div class="flex min-h-screen items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">

            <form class="mt-8 space-y-4" action="{{ route('auth.login.store') }}" method="POST">
                @csrf

                <div>
                    <label for="email"
                           class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email Address') }}</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input
                                id="email"
                                name="email"
                                dusk="email"
                                type="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6
                            @error('email') text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500 @enderror"
                                placeholder="{{ __('Email Address') }}"
                                value="{{ old('email') }}"
                                @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                required
                                autocomplete="email">

                        @error('email')
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @enderror
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600" id="email-error">
                        {{$message}}
                    </p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                           class="block text-sm font-medium leading-6 text-gray-900">{{ __('Password') }}</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input
                                id="password"
                                name="password"
                                dusk="password"
                                type="password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6
                            @error('password') text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500 @enderror"
                                placeholder="{{ __('Password') }}"
                                value="{{ old('password') }}"
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                                required
                                autocomplete="current-password">

                        @error('password')
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @enderror
                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600" id="email-error">
                        {{$message}}
                    </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                        <label for="remember"
                               class="ml-2 block text-sm text-gray-900">{{ __('Remember Me') }}</label>
                    </div>

                </div>

                <div class="space-y-4">
                    <button
                        type="submit"
                        dusk="login-button"
                        class="rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 w-full">
                        {{ __('Sign In') }}
                    </button>

                    <a
                        href="{{ route('auth.provider', \CodebarAg\LaravelAuth\Enums\ProviderEnum::MICROSOFT_OFFICE_365()) }}"
                        dusk="microsoft-login-button"
                        class="inline-flex items-center justify-center gap-x-2 rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 w-full">
                        <svg class="fill-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 278050 333334" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><path fill="currentColor" d="M278050 305556l-29-16V28627L178807 0 448 66971l-448 87 22 200227 60865-23821V80555l117920-28193-17 239519L122 267285l178668 65976v73l99231-27462v-316z"/></svg>
                        <span>{{ __('Sign In with Microsoft') }}</span>
                    </a>

                </div>

            </form>


        </div>
    </div>

</main>

<footer class="bg-white">
    <div class="mx-auto max-w-7xl overflow-hidden py-20 px-6 sm:py-24 lg:px-8 space-y-4">

        <p class="text-center text-xs leading-5 text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}.
            {{ __('All rights reserved') }}.
        </p>

    </div>
</footer>


</body>
</html>

