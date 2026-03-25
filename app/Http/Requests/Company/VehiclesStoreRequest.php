<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class VehiclesStoreRequest extends FormRequest
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
            'base_daily_rate'               => 'required|numeric|min:0',
            'plate'                         => 'nullable|string|max:50',
            'vin'                           => 'required|string|size:17|regex:/^[A-HJ-NPR-Z0-9]{17}$/i',
            'registration_expiry'           => 'nullable|date',
            'insurance_expiry'              => 'nullable|date',
            'year'                          => 'nullable|integer|min:1900|max:' . date('Y'),
            'slug'                          => 'nullable|string|unique:vehicles,slug','regex:/^[a-z0-9]+(_[a-z0-9]+)*$/',
            'mileage'                       => 'nullable|integer|min:0',
            'color'                         => 'nullable|string|max:50',
            'notes'                         => 'nullable|string|max:5000',
            'vehicle_model_id'              => 'required|exists:vehicle_models,id',
            'vehicle_category_id'           => 'required|exists:vehicle_categories,id',
            'fuel_type_id'                  => 'required|exists:fuel_types,id',
            'transmission_type_id'          => 'required|exists:transmission_types,id',
            'vehicle_status_id'             => 'required|exists:vehicle_statuses,id',
            'seats'                         => 'required|integer|min:1',
            'engine_size'                   => 'nullable',
            'min_drive_age'                 => 'nullable|integer|min:18',
            'max_drive_age'                 => 'nullable|integer|max:90',
        ];
    }
}
