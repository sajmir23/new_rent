<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalServiceStoreRequest extends FormRequest
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
            'title_en'              => 'required|string|max:255',
            'title_it'              => 'required|string|max:255',
            'title_al'              => 'required|string|max:255',
            'title_es'              => 'required|string|max:255',
            'title_fr'              => 'required|string|max:255',
            'title_de'              => 'required|string|max:255',
            'description_en'        => 'required|string',
            'description_it'        => 'required|string',
            'description_al'        => 'required|string',
            'description_es'        => 'required|string',
            'description_fr'        => 'required|string',
            'description_de'        => 'required|string',
            'service_price'         => 'required|numeric|min:0',
        ];
    }
}
