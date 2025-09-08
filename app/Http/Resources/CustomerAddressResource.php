<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->_id ?? $this->id,
            'customer_id' => $this->customer_id,
            'address' => $this->address,
            'is_default' => $this->is_default,
        ];
    }
}
