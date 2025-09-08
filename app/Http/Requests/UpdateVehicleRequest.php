<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'license_plate' => 'sometimes|string|min:5|max:15',
            'make' => 'sometimes|string|max:50',
            'model' => 'sometimes|string|max:50',
            'year' => 'sometimes|integer|min:1900',
            'color' => 'nullable|string|max:30',
            'vin' => 'nullable|string|max:30|unique:vehicles,vin',
            'mileage' => 'nullable|integer|min:0',
            'photos' => 'nullable|array',
            'is_primary' => 'sometimes|boolean',
            'insurance_info' => 'nullable|array',
            'registration_expiry' => 'nullable|date',
        ];
    }
}
