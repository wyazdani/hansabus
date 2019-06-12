<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',150);
            $table->string('year',4);
            $table->string('make',100);
            $table->string('engineNumber',100);
            $table->integer('vehicle_type')->unsigned()->index();
            $table->string('licensePlate',50);
            $table->integer('seats');
            $table->string('color');
            $table->string('registrationNumber',100);            
            $table->enum('transmission', ['Automatic', 'Manual']);
            $table->boolean('AC');
            $table->boolean('radio');
            $table->boolean('sunroof');            
            $table->boolean('phoneCharging');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('vehicle_type')->references('id')->on('vehicle_types')->onDelete('cascade');

            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle');
    }
}
