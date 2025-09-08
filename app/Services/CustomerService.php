<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Str;
class CustomerService
{

    private function generateReferralCode($fisrtName, $lastName)
    {
        $base = strtoupper($fisrtName . $lastName);
        do {
            $random = strtoupper(Str::random(10));
            $referralCode = $base . $random;
        } while (Customer::query()->where('referralCode', $referralCode)->exists());

        return $referralCode;
    }
    public function getByUserId($userId)
    {
        return Customer::where('user_id', $userId)->first();
    }

    public function create(array $customerData)
    {
        $userId = 1;
        if ($this->getByUserId($userId)) {
            throw new \Exception('قبلاً برای این کاربر مشتری ثبت شده است.');
        }
        $referralCode = $this->generateReferralCode($customerData['first_name'], $customerData['last_name']);
        $customer = Customer::create(array_merge($customerData, ['referral_code' => $referralCode, 'user_id' => $userId]));
        return $customer;
    }

    public function update(array $customerData, int $userId)
    {
        $customer = $this->getByUserId($userId);
        $customer = $customer->update(array_filter($customerData));
        return $customer;

    }

    public function addAddress(int $userId, array $addressData)
    {
        $customer = $this->getByUserId($userId);
        if (!$customer->addresses()->exists() || $addressData['is_default']) {
            $customer->addresses()->update([
                'is_default' => false
            ]);
            $addressData['is_default'] = true;
        }
        $address = $customer->addresses()->create($addressData);
        return $address;
    }


}
