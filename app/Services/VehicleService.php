<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Vehicle;

class VehicleService
{
    public function store(array $data, $customerId)
    {
        $customer = Customer::find($customerId);
        if (!$customer->vehicles()->exists() || $data['is_primary']) {
            $customer->vehicles()->update([
                'is_primary' => false
            ]);
            $data['is_primary'] = true;
        }
        $vehicle = $customer->vehicles()->create($data);
        return $vehicle;
    }
    public function getByCustomerId($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        return $customer->vehicles;
    }


        public function getVehicle($customerId, $vehicleId)
    {
        return \App\Models\Vehicle::where('customer_id', $customerId)->where('_id', $vehicleId)->first();
        //از دستی اومدم اینو روی vehicle کوعری نوشتم و مثل بالایی از هلپر استفاده نکردم که جفتشون رو استفاده کرده باشم
    }

        public function updateVehicle($customerId, $vehicleId, array $data)
    {
        $vehicle = \App\Models\Vehicle::where('customer_id', $customerId)->where('_id', $vehicleId)->first();
        if (!$vehicle) {
            throw new \Exception('خودرو پیدا نشد');
        }
        $vehicle->update($data);
        return $vehicle;
    }

        public function deleteVehicle($customerId, $vehicleId)
    {
        $vehicle = \App\Models\Vehicle::where('customer_id', $customerId)->where('_id', $vehicleId)->first();
        if (!$vehicle) {
            throw new \Exception('خودرو پیدا نشد');
        }
        $vehicle->delete();
        return true;
    }


}
