<x-auth::layout>
    <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('auth::translations.verify-email') }}</h2>

    <form class="mt-8 space-y-4" action="{{ route('auth.verification.send') }}" method="POST">
        @csrf
        @honeypot

        <div class="text-center">
            <p class="block text-sm font-medium leading-6 text-gray-900 mt-2">{{ __('auth::translations.before-continuing') }}</p>
            <p class="block text-sm font-medium leading-6 text-gray-900 mt-2">{{ __('auth::translations.didnt-receive') }}</p>
        </div>


        <div class="space-y-4">
            <x-auth::form.button.button>
                {{ __('auth::translations.resend-verification-email') }}
            </x-auth::form.button.button>
        </div>

    </form>
</x-auth::layout>
