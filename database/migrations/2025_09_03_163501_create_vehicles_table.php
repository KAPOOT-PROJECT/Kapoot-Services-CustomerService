<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $collection) {
            $collection->string('_id')->primary();

            $collection->string('customer_id');

            $collection->string('license_plate');
            $collection->string('make');
            $collection->string('model');
            $collection->integer('year');
            $collection->string('color')->nullable();
            $collection->string('vin')->nullable()->unique();
            $collection->integer('mileage')->nullable();
            $collection->timestamp('last_updated_mileage')->nullable();
            $collection->json('photos')->nullable();
            $collection->boolean('is_primary')->default(false);
            $collection->json('insurance_info')->nullable();
            $collection->date('registration_expiry')->nullable();
            $collection->timestamps();
            $collection->softDeletes();
            $collection->index('customer_id');
            $collection->index('license_plate');
            $collection->index('vin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
