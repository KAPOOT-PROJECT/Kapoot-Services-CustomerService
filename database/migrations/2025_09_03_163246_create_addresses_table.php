<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $collection) {

            $collection->string('_id')->primary();
            $collection->string('customer_id');

            $collection->string('title')->default('Home');
            $collection->string('street_address');
            $collection->string('apartment')->nullable();
            $collection->string('city');
            $collection->string('state')->nullable();
            $collection->string('postal_code');
            $collection->string('country');

            $collection->double('latitude')->nullable();
            $collection->double('longitude')->nullable();

            $collection->boolean('is_default')->default(false);
            $collection->timestamps();
            $collection->softDeletes();
            $collection->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
