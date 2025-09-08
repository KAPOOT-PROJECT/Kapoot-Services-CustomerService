<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->_id,
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'national_id' => $this->national_id,
            'date_of_birth' => $this->date_of_birth,
            'preferred_payment_method' => $this->preferred_payment_method,
            'loyalty_points' => $this->loyalty_points,
            'referral_code' => $this->referral_code,
            'preferences' => $this->preferences,
            'addresses' => CustomerAddressResource::collection($this->addresses),
            'vehicles' => CustomerVehicleResource::collection($this->vehicles),
        ];
    }
}
