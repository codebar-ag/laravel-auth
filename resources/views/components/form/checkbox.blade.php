@props([
	'label',
	'name',
	'value' => null,
	'helper' => null,
	'autocomplete' => null,
	'required' => false,
	'autofocus' => false,
	'disabled' => false,
	'readonly' => false,
])

<div class="flex items-center">
    <input
        id="{{ $name }}" name="{{ $name }}"
        type="checkbox"
        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @checked(old($name, $value))
    >
    @if($label)
        <label for="remember" class="ml-2 block text-sm text-gray-900">
            {{ $label }}
        </label>
    @endif

    @if($helper)
        <p class="mt-2 text-xs text-gray-500" id="{{ $name .'-description'  }}">
            {{ $helper }}
        </p>
    @endif
    @error($name)
    <p class="mt-2 text-sm text-red-600" id="{{ $name .'-error'  }}">
        {{$message}}
    </p>
    @enderror
</div>
