<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CancellationReasonsStoreRequest extends FormRequest
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
            'title_en'          => 'required|string|max:255',
            'title_it'          => 'nullable|string|max:255',
            'title_al'          => 'nullable|string|max:255',
            'title_es'          => 'nullable|string|max:255',
            'title_fr'          => 'nullable|string|max:255',
            'title_de'          => 'nullable|string|max:255',
        ];
    }
}
