@props([
	'attributes',
	'label',
	'name',
	'placeholder' => null,
	'helper' => null,
	'autocomplete' => null,
	'required' => false,
	'autofocus' => false,
	'disabled' => false,
	'readonly' => false,
	'requiredBadge' => true,
	'optionalBadge' => true,
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
        <div class="relative mt-2 flex items-center" x-data="{ showPassword: false }">
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                dusk="{{ $name }}"
                :type="showPassword ? 'text' : 'password'"
                class="focus:shadow-none block w-full rounded-md border-0 py-1.5 pr-10 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6
                @error($name) text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500 @enderror"

                @error($name) aria-invalid="true" aria-describedby="{{ $name . '-error' }} @enderror"
                @if($required) required @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($autofocus) autofocus @endif
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            >
            <div x-on:click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                <div class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">
                    <svg x-show="!showPassword" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="showPassword" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z"/>
                        <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z"/>
                        <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z"/>
                    </svg>

                </div>
            </div>
        </div>

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
