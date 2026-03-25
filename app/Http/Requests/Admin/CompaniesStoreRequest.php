<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesStoreRequest extends FormRequest
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
            // Company fields
            'name'                       => ['required', 'string', 'max:255'],
            'email'                      => ['required', 'email', 'max:255'],
            'phone'                      => ['required', 'string', 'max:20'],
            'address'                    => ['nullable', 'string', 'max:500'],
            'notes'                      => ['nullable', 'string', 'max:1000'],
            'city_id'                    => ['nullable', 'exists:cities,id'],
            'logo'                       => ['nullable', 'image', 'max:2048'], // 2MB max
            'booking_fee_percentage'     => ['required', 'numeric', 'min:0', 'max:100',],


            // Admin user fields
            'first_name'                 => ['required', 'string', 'max:255'],
            'last_name'                  => ['nullable', 'string', 'max:255'],
            'phone_number'               => ['nullable', 'string', 'max:20'],
            'address_admin'              => ['nullable', 'string', 'max:500'],
            'password'                   => ['required', 'string', 'min:8', 'confirmed'],
            'email_admin'                => ['required', 'email', 'max:255', 'unique:users,email'],
        ];
    }
}
