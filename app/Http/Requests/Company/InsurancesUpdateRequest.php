<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class InsurancesUpdateRequest extends FormRequest
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
            'title_en'                  => 'nullable|string|max:100',
            'title_it'                  => 'nullable|string|max:100',
            'title_al'                  => 'nullable|string|max:100',
            'title_es'                  => 'nullable|string|max:100',
            'title_de'                  => 'nullable|string|max:100',
            'title_fr'                  => 'nullable|string|max:100',
            'description_en'            => 'nullable|string|max:500',
            'description_it'            => 'nullable|string|max:500',
            'description_al'            => 'nullable|string|max:500',
            'description_es'            => 'nullable|string|max:500',
            'description_de'            => 'nullable|string|max:500',
            'description_fr'            => 'nullable|string|max:500',
            'price_per_day'             => 'nullable|numeric',
            'deposit_price'             => 'nullable|numeric',
            'theft_protection_price'    => 'nullable|numeric',
        ];
    }
}
