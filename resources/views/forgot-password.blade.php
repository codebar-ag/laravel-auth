<x-auth::layout>
    <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('auth::translations.forgot-your-password') }}</h2>

    <form class="mt-8 space-y-4" action="{{ route('auth.request-password.store') }}" method="POST">
        @csrf

        @honeypot

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

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('auth.login') }}"
                   class="block text-sm text-gray-900 hover:text-gray-500 underline">{{ __('auth::translations.back-to-login') }}</a>
            </div>
        </div>

        <div class="space-y-4">
            <x-auth::form.button.button>
                {{ __('auth::translations.request-password-reset') }}
            </x-auth::form.button.button>
        </div>
    </form>
</x-auth::layout>
