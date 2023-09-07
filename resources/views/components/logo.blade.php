@if(config('laravel-auth.logo.path'))
    <img src="{{ asset(config('laravel-auth.logo.path')) }}" alt="{{__('Logo')}}" {{ $attributes->merge(['class' => 'mx-auto w-[25%]']) }}>
@endif
