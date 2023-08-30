@extends('auth.layouts.default')

@section('content')
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-branding.logo/>
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('Verify Email') }}</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[520px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    @honeypot

                    <div>
                        <label class="block text-md font-medium leading-6 text-gray-900">{{ __('Hello :name', ['name' => auth()->user()->name]) }},</label>
                        <p class="block text-sm font-medium leading-6 text-gray-900 mt-2">{{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you?') }}</p>
                        <p class="block text-sm font-medium leading-6 text-gray-900 mt-2">{{ __('If you didn\'t receive the email, we will gladly send you another.') }}</p>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-teal-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
