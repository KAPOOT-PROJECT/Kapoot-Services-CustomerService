<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Http\Resources\CustomerResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(private readonly CustomerService $customerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    use ResponseTrait;

    public function store(CreateCustomerRequest $request)
    {
        try {
            $customer = $this->customerService->create($request->validated());
            return self::success(new CustomerResource($customer), 'مشتری با موفقیت ثبت شد', 201);
        } catch (\Throwable $th) {
            return self::error(['error' => 'storing customer faild', 'message' => $th->getMessage()], 'خطا در ثبت مشتری', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function me()
    {
        $customer = $this->customerService->getByUserId(1);
        if (!$customer) {
            return self::error(null, 'مشتری پیدا نشد', 404);
        }
        return self::success(new CustomerResource($customer), 'اطلاعات مشتری');
    }


        public function show(int $customer_id)
    {
        $customer = $this->customerService->getByUserId($customer_id);
        if (!$customer) {
            return self::error(null, 'مشتری پیدا نشد', 404);
        }
        return self::success(new CustomerResource($customer), 'اطلاعات مشتری');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request)
    {
        try {
            $customer = $this->customerService->update($request->validated(), 1);
            return self::success($customer, 'اطلاعات مشتری بروزرسانی شد');
        } catch (\Throwable $th) {
            return self::error(['error' => 'updating customer faild', 'message' => $th->getMessage()], 'خطا در بروزرسانی مشتری', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
