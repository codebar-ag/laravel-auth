<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth h-full bg-gray-50">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ asset('vendor/auth/authcss.css') }}">
        <script src="{{ asset('vendor/auth/authjs.js') }}" defer></script>
    </head>

    <body class="font-sans antialiased h-full">

        @if (flash()->message)
            <x-auth::flash-message :status="flash()->class" :message="flash()->message"/>
        @endif

        <main>
            <div class="flex min-h-screen items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="w-full max-w-md space-y-8 mx-auto">

                    <x-auth::logo />

                    {{ $slot }}

                    <x-auth::footer/>
                </div>
            </div>
        </main>
    </body>
</html>
