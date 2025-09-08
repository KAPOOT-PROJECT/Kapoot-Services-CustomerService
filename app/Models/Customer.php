<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;

class Customer extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'customers';

    protected $fillable = [
        '_id',
        'user_id',
        'first_name',
        'last_name',
        'national_id',
        'date_of_birth',
        'preferred_payment_method',
        'loyalty_points',
        'referral_code',
        'preferences',
    ];


    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id', '_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'customer_id', '_id');
    }

    /**
     * Scope a query to get default customer address.
     */
    #[Scope]
    protected function default_address()
    {
        return $this->addresses()->where('is_default', true)->first();
    }

    /**
     * Scope a query to get primary vehicle.
     */
    #[Scope]
    protected function primary_vehicle()
    {
       return $this->vehicles()->where('is_primary', true)->first();
    }
}
