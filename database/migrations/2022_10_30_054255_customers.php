<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code')->unique()->nullable();
            $table->string('customer_phone')->nullable()->unique();
            $table->string('customer_password')->nullable();
            $table->string('customer_name')->nullable();
            $table->tinyInteger('customer_gender')->default(0);
            $table->string('customer_address')->nullable();
            $table->string('customer_email')->nullable()-unique();
            $table->string('city_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('customers');
    }
}
