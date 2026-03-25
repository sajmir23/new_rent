<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UsersStoreRequest extends FormRequest
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
            'approved_google_login'      => ['required', 'numeric'],
            'role_id'      => ['required', 'numeric'],
            'status'       => ['required', 'numeric'],
            'phone_number' => ['nullable', 'string'],
            'address'      => ['nullable', 'string'],
            'notes'        => ['nullable', 'string'],
            'name'         => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
