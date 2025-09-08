<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class Vehicle extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vehicles';
    protected $fillable = [
        'customer_id',
        'license_plate',
        'make',
        'model',
        'year',
        'color',
        'vin',
        'mileage',
        'last_updated_mileage',
        'photos',
        'is_primary',
        'insurance_info',
        'registration_expiry',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', '_id');
    }

    public function makeVehiclePrimary()
    {
        self::where('customer_id', $this->customer_id)
            ->where('_id', '!=', $this->_id)
            ->update(['is_primary' => false]);
        $this->is_primary = true;
        $this->save();
    }

    public function getFullVehicleDetailAttribute()
    {
        return "your full Vehicle detail of {$this->model}: {$this->color}, {$this->license_plate}";
    }

    public function isRegistrationExpired()
    {
        return $this->registration_expiry && $this->registration_expiry <= now();
    }

    public function daysUntilRegistrationExpiry()
    {
        if ($this->registration_expiry) {
            return 0;
        }
        return now()->diffInDays($this->registration_expiry);
    }
}
