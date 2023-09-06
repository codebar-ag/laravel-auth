<x-auth::layout>
    <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ __('Verify Email') }}</h2>

    <form class="mt-8 space-y-4" action="{{ route('auth.verification.send') }}" method="POST">
        @csrf
        @honeypot

        <div class="text-center">
            <p class="block text-sm font-medium leading-6 text-gray-900 mt-2">{{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you?') }}</p>
            <p class="block text-sm font-medium leading-6 text-gray-900 mt-2">{{ __('If you didn\'t receive the email, we will gladly send you another.') }}</p>
        </div>


        <div class="space-y-4">
            <x-auth::form.button.button>
                {{ __('Resend Verification Email') }}
            </x-auth::form.button.button>
        </div>

    </form>
</x-auth::layout>
