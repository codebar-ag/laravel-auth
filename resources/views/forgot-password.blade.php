@extends('auth.layouts.default')

@section('content')
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-branding.logo/>
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('Forgot Your Password?') }}</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[520px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" action="{{ route('request-password.store') }}" method="POST">
                    @csrf
                    @honeypot

                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email Address') }}</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required placeholder="{{ __('Email Address') }}"
                                   class="focus:shadow-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6"
                                   value="{{ old('email') }}"
                            >
                        </div>
                        @error('email')
                        <span class="text-sm text-red-500">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm leading-6">
                            <a href="{{ route('login') }}" class="font-semibold text-teal-600 hover:text-teal-500">
                                {{ __('Back to login') }}</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-teal-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                            {{ __('Request Password Reset') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
