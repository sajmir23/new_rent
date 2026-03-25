<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class InsurancesStoreRequest extends FormRequest
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
            'title_en'                  => 'required|string|max:100',
            'title_it'                  => 'required|string|max:100',
            'title_al'                  => 'required|string|max:100',
            'title_es'                  => 'required|string|max:100',
            'title_de'                  => 'required|string|max:100',
            'title_fr'                  => 'required|string|max:100',
            'description_en'            => 'required|string|max:500',
            'description_it'            => 'required|string|max:500',
            'description_al'            => 'required|string|max:500',
            'description_es'            => 'required|string|max:500',
            'description_de'            => 'required|string|max:500',
            'description_fr'            => 'required|string|max:500',
            'price_per_day'             => 'required|numeric',
            'deposit_price'             => 'nullable|numeric',
            'theft_protection_price'    => 'nullable|numeric',
        ];
    }
}
