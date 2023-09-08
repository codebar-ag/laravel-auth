<x-auth::layout>
    <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('auth::translations.reset-your-password') }}</h2>

    <form class="mt-8 space-y-4" action="{{ route('auth.reset-password.store') }}" method="POST">
        @csrf
        @honeypot

        <input class="border-0 focus:shadow-none" type="hidden" name="token" value="{{ $token }}">

        <x-auth::form.input
                type="email"
                name="email"
                :label="__('auth::translations.email')"
                :placeholder="__('auth::translations.email')"
                autocomplete="email"
                :required="true"
                :required-badge="false"
                :autofocus="true"
        />

        <x-auth::form.password
                name="password"
                :label="__('auth::translations.password')"
                :placeholder="__('auth::translations.password')"
                autocomplete="password"
                :required="true"
                :required-badge="false"
        />

        <x-auth::form.password
                name="password_confirmation"
                :label="__('auth::translations.confirm-password')"
                :placeholder="__('auth::translations.confirm-password')"
                autocomplete="password"
                :required="true"
                :required-badge="false"
        />

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('auth.login') }}"
                   class="block text-sm text-gray-900 hover:text-gray-500 underline">{{ __('auth::translations.back-to-login') }}</a>
            </div>
        </div>

        <div class="space-y-4">
            <x-auth::form.button.button>
                {{ __('auth::translations.reset-password') }}
            </x-auth::form.button.button>
        </div>

    </form>
</x-auth::layout>
