@if(config('laravel-auth.logo.path'))
    @if(!filter_var(config('laravel-auth.logo.path'), FILTER_VALIDATE_URL))
        <img src="{{ asset(config('laravel-auth.logo.path')) }}" alt="{{__('auth::translations.logo')}}" {{ $attributes->merge(['class' => 'mx-auto', 'style' => 'width: '. config('laravel-auth.logo.width', '25%') .';']) }}>
    @else
        <img src="{{ config('laravel-auth.logo.path') }}" alt="{{__('auth::translations.logo')}}" {{ $attributes->merge(['class' => 'mx-auto', 'style' => 'width: '. config('laravel-auth.logo.width', '25%') .';']) }}>
    @endif
@endif
