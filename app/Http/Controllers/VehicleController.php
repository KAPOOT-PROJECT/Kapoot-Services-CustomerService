<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Services\VehicleService;
use App\Http\Resources\CustomerVehicleResource;
use App\Traits\ResponseTrait;

class VehicleController extends Controller
{
    use ResponseTrait;
    public function __construct(private readonly VehicleService $vehicleService)
    {
    }

    public function store(StoreVehicleRequest $request, string $customer_id)
    {
        try {
            $vehicle = $this->vehicleService->store($request->validated(), $customer_id);
            return self::success(new CustomerVehicleResource($vehicle), 'خودرو با موفقیت ثبت شد', 201);
        } catch (\Throwable $th) {
            return self::error(['error' => 'storing vehicle faild', 'message' => $th->getMessage()], 'خطا در ثبت خودرو', 500);
        }
    }


        public function index(string $customer_id)
    {
        try {
            $vehicles = $this->vehicleService->getByCustomerId($customer_id);
            return self::success(CustomerVehicleResource::collection($vehicles), 'لیست خودروها');
        } catch (\Throwable $th) {
            return self::error(['error' => 'fetching vehicles failed', 'message' => $th->getMessage()], 'خطا در دریافت لیست خودروها', 500);
        }
    }


        public function show($customer_id, $vehicle_id)
    {
        try {
            $vehicle = $this->vehicleService->getVehicle($customer_id, $vehicle_id);
            if (!$vehicle) {
                return self::error(null, 'خودرو پیدا نشد', 404);
            }
            return self::success(new CustomerVehicleResource($vehicle), 'اطلاعات خودرو');
        } catch (\Throwable $th) {
            return self::error(['error' => 'fetching vehicle failed', 'message' => $th->getMessage()], 'خطا در دریافت اطلاعات خودرو', 500);
        }
    }

        public function update(UpdateVehicleRequest $request, $customer_id, $vehicle_id)
    {
        try {
            $vehicle = $this->vehicleService->updateVehicle($customer_id, $vehicle_id, $request->validated());
            return self::success(new \App\Http\Resources\CustomerVehicleResource($vehicle), 'خودرو با موفقیت بروزرسانی شد');
        } catch (\Throwable $th) {
            return self::error(['error' => 'updating vehicle failed', 'message' => $th->getMessage()], 'خطا در بروزرسانی خودرو', 500);
        }
    }


        public function destroy($customer_id, $vehicle_id)
    {
        try {
            $this->vehicleService->deleteVehicle($customer_id, $vehicle_id);
            return self::success(null, 'خودرو با موفقیت حذف شد');
        } catch (\Throwable $th) {
            return self::error(['error' => 'deleting vehicle failed', 'message' => $th->getMessage()], 'خطا در حذف خودرو', 500);
        }
    }

    // سایر متدهای CRUD را می‌توان بعداً اضافه کرد
}
