<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required | string | min:3 | max:20',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | string | min:6 | max:20',
        ];
    }

    public function messages()
    {
        return [
            'username' => 'username should  be between 3 and 20 digits',
            'email' => 'email is already exists',
            'password' => 'must be between 6 and 20 digits',
        ];
    }
}
