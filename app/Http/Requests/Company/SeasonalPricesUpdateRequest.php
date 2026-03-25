<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class SeasonalPricesUpdateRequest extends FormRequest
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
            'start_date' => ['nullable', 'date_format:d-m-Y'],
            'end_date'   => [
                'nullable',
                'date_format:d-m-Y',
                'after_or_equal:start_date',
            ],
            'rate_multiplier' => 'nullable|numeric|min:0',
        ];
    }
}
