@props(['href', 'attributes'])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-x-2 rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 w-full']) }}
>
    {{ $slot }}
</a>
