<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends FormRequest
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
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'birthday'           => 'required|date_format:d-m-Y',
            'email'              => 'required|email',
            'phone'              => 'required|string|max:20',
            'additional_phone'   => 'nullable|string|max:20',
            'days'               => 'nullable|integer|min:1',
            'daily_rate'         => 'nullable|numeric|min:0',
            'total_price'        => 'nullable|numeric|min:0',
            'addons_total'       => 'nullable|numeric|min:0',
            'pickup_date'        => 'required|date_format:d-m-Y|after_or_equal:today',
            'dropoff_date'       => 'required|date_format:d-m-Y|after_or_equal:pickup_date',
            'pickup_time'        => 'required|date_format:H:i',
            'dropoff_time'       => 'required|date_format:H:i',
            'ways_of_contact'    => 'nullable|in:1,2,3',
            'vehicle_id'         => 'required|exists:vehicles,id',
            'insurance_id'       => 'required|exists:insurances,id',
            'pickup_location'    => 'required|exists:deliveries,id',
            'dropoff_location'   => 'required|exists:deliveries,id',
            'notes'              => 'nullable|string',
        ];
    }
}
