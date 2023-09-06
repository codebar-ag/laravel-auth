<x-auth::layout>
    <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('Reset Your Password') }}</h2>

    <form class="mt-8 space-y-4" action="{{ route('auth.reset-password.store') }}" method="POST">
        @csrf
        @honeypot

        <input class="border-0 focus:shadow-none" type="hidden" name="token" value="{{ $token }}">

        <x-auth::form.input
                type="email"
                name="email"
                label="Email"
                placeholder="Email"
                autocomplete="email"
                :required="true"
                :required-badge="false"
                :autofocus="true"
        />

        <x-auth::form.password
                name="password"
                label="Password"
                placeholder="Password"
                autocomplete="password"
                :required="true"
                :required-badge="false"
        />

        <x-auth::form.password
                name="password_confirmation"
                label="Confirm Password"
                placeholder="Confirm Password"
                autocomplete="password"
                :required="true"
                :required-badge="false"
        />

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('auth.login') }}"
                   class="block text-sm text-gray-900 hover:text-gray-500 underline">{{ __('Back to Login') }}</a>
            </div>
        </div>

        <div class="space-y-4">
            <x-auth::form.button.button>
                {{ __('Reset Password') }}
            </x-auth::form.button.button>
        </div>

    </form>
</x-auth::layout>
