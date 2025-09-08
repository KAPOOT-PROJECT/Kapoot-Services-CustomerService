<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $collection) {
            $collection->string('_id')->primary();
            $collection->unsignedBigInteger('user_id');
            $collection->string('first_name');
            $collection->string('last_name');
            $collection->string('national_id');
            $collection->date('date_of_birth')->nullable();
            $collection->string('preferred_payment_method')->nullable();
            $collection->integer('loyalty_points')->default(0);
            $collection->string('referral_code')->unique()->nullable();
            $collection->json('preferences')->nullable();
            $collection->timestamps();
            $collection->softDeletes();
            $collection->index('user_id');
            $collection->index('referral_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
