<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('driver_id')->default(0)->nullable();
            $table->bigInteger('booking_id')->default(0)->nullable();
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->boolean('with_vehicle')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_bookings');
    }
}
