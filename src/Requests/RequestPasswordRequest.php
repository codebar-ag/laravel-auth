<?php

namespace CodebarAg\LaravelAuth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
