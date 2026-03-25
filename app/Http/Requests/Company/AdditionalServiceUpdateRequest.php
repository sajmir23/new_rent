<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalServiceUpdateRequest extends FormRequest
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
            'title_en'              => 'nullable|string|max:255',
            'title_it'              => 'nullable|string|max:255',
            'title_al'              => 'nullable|string|max:255',
            'title_es'              => 'nullable|string|max:255',
            'title_fr'              => 'nullable|string|max:255',
            'title_de'              => 'nullable|string|max:255',
            'description_en'        => 'nullable|string',
            'description_it'        => 'nullable|string',
            'description_al'        => 'nullable|string',
            'description_es'        => 'nullable|string',
            'description_fr'        => 'nullable|string',
            'description_de'        => 'nullable|string',
            'service_price'         => 'nullable|numeric|min:0',
        ];
    }
}
