<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerVehicleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->_id ?? $this->id,
            'customer_id' => $this->customer_id,
            'license_plate' => $this->license_plate,
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'color' => $this->color,
            'vin' => $this->vin,
            'mileage' => $this->mileage,
            'last_updated_mileage' => $this->last_updated_mileage,
            'photos' => $this->photos,
            'is_primary' => $this->is_primary,
            'insurance_info' => $this->insurance_info,
            'registration_expiry' => $this->registration_expiry,
        ];
    }
}
