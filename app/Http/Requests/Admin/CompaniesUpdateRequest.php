<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompaniesUpdateRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            // Company fields
            'name'                       => ['nullable', 'string', 'max:255'],
            'email'                      => ['nullable', 'email', 'max:255'],
            'phone'                      => ['nullable', 'string', 'max:20'],
            'address'                    => ['nullable', 'string', 'max:500'],
            'notes'                      => ['nullable', 'string', 'max:1000'],
            'city_id'                    => ['nullable', 'exists:cities,id'],
            'logo'                       => ['nullable', 'image', 'max:2048'], // 2MB max
            'booking_fee_percentage'     => ['nullable', 'numeric', 'min:0', 'max:100',],

            // Admin user fields
            'first_name'                 => ['nullable', 'string', 'max:255'],
            'last_name'                  => ['nullable', 'string', 'max:255'],
            'phone_number'               => ['nullable', 'string', 'max:20'],
            'address_admin'              => ['nullable', 'string', 'max:500'],
            'password'                   => ['nullable', 'string', 'min:8', 'confirmed'],
            'email_admin'  => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(
                    \App\Models\User::where('company_id', $userId)
                        ->where('user_type', UserTypesEnum::COMPANY_ADMIN)
                        ->value('id')
                ),
            ],

        ];
    }
}
