<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Address extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'addresses';

    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', '_id');
    }



    public function makeAddressDefault()
    {
        self::where('customer_id', $this->customer_id)
            ->where('_id', '!=', $this->_id)
            ->update(['is_default' => false]);

        $this->is_default = true;
        $this->save();
    }

    /**
     * Get the costomer full address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "your full address of {$this->title}: {$this->street_address}, {$this->city}, {$this->state}, {$this->postal_code}, {$this->country}";
    }
}
