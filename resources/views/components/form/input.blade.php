@props([
	'attributes',
	'label',
	'name',
	'type',
	'placeholder' => null,
	'value' => null,
	'helper' => null,
	'autocomplete' => null,
	'required' => false,
	'autofocus' => false,
	'disabled' => false,
	'readonly' => false,
	'requiredBadge' => true,
	'optionalBadge' => true,
	'area' => false,
])

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name }}" class="flow-root text-sm font-medium leading-6 text-gray-900">
        {{ $label }}
        <span class="float-left"></span>
        @if($optionalBadge && !$required)
            <span class="float-right inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                  {{ __('optional') }}
            </span>
        @endif
        @if($requiredBadge && $required)
            <span class="float-right inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                  {{ __('required') }}
            </span>
        @endif
    </label>
    <div class="relative mt-2 rounded-md shadow-sm">
        @if($area)
        <textarea
        @else
        <input
        @endif
                id="{{ $name }}"
                name="{{ $name }}"
                dusk="{{ $name }}"
                type="{{ $type }}"
                value="{{ old($name, $value) }}"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6
                @error($name) text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500 @enderror"

                @error($name) aria-invalid="true" aria-describedby="{{ $name . '-error' }} @enderror"
                @if($required) required @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($autofocus) autofocus @endif
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($area)
            ></textarea>
        @else
            >
        @endif

        @error($name)
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                      clip-rule="evenodd"/>
            </svg>
        </div>
        @enderror
    </div>
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
