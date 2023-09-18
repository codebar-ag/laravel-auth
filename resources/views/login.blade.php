<x-auth::layout>
    <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('auth::translations.login') }}</h2>

    <form class="mt-8 space-y-4" action="{{ route('auth.login.store') }}" method="POST">
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

        <x-auth::form.password
                name="password"
                :label="__('auth::translations.password')"
                :placeholder="__('auth::translations.password')"
                autocomplete="password"
                :required="true"
                :required-badge="false"
        />

        <div class="flex items-center justify-between">
            <x-auth::form.checkbox
                name="remember"
                :label="__('auth::translations.remember-me')"
            />

            @if(config('laravel-auth.features.password_reset'))
                <div class="flex items-center">
                    <a href="{{ route('auth.request-password') }}"
                           class="block text-sm text-gray-900 hover:text-gray-500 underline">{{ __('auth::translations.forgot-password') }}</a>
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <x-auth::form.button.button>
                {{ __('auth::translations.sign-in') }}
            </x-auth::form.button.button>

            @if(! in_array(\CodebarAg\LaravelAuth\Enums\ProviderEnum::MICROSOFT_OFFICE_365(), config('laravel-auth.providers.disabled')))
                <x-auth::form.button.ahref
                    :href="route('auth.provider', \CodebarAg\LaravelAuth\Enums\ProviderEnum::MICROSOFT_OFFICE_365())"
                    class="bg-gray-500 hover:bg-gray-400"
                >
                    <svg class="fill-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 278050 333334" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><path fill="currentColor" d="M278050 305556l-29-16V28627L178807 0 448 66971l-448 87 22 200227 60865-23821V80555l117920-28193-17 239519L122 267285l178668 65976v73l99231-27462v-316z"/></svg>
                    <span>{{ __('auth::translations.sign-in-with-microsoft') }}</span>
                </x-auth::form.button.ahref>
            @endif
        </div>

    </form>
</x-auth::layout>
