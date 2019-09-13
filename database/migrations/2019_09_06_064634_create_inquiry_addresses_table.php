<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiryAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inquiry_id')->nullable();
            $table->text('from_address')->nullable();
            $table->text('to_address')->nullable();
            $table->dateTime('time')->nullable();
            $table->tinyInteger('trip_type')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('inquiry_addresses');
    }
}
