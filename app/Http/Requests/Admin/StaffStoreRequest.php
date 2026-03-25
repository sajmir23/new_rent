<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StaffStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'            => ['required', 'string', 'max:255'],
            'last_name'             => ['required', 'string', 'max:255'],
            'phone_number'          => ['required', 'string', 'max:20'],
            'address'               => ['nullable', 'string', 'max:500'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],

        ];
    }
}
