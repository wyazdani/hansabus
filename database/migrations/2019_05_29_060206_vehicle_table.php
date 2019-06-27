<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VehicleTable extends Migration
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
            $table->string('name',150)->nullable();
            $table->string('year',4)->nullable();
            $table->string('make',100)->nullable();
            $table->string('engineNumber',100)->nullable();
            $table->integer('vehicle_type')->unsigned()->index()->nullable();
            $table->string('licensePlate',50)->nullable();
            $table->integer('seats')->nullable();
            $table->string('color')->nullable();
            $table->string('registrationNumber',100)->nullable();
            $table->enum('transmission', ['Automatic', 'Manual'])->nullable();
            $table->boolean('AC')->nullable();
            $table->boolean('radio')->nullable();
            $table->boolean('sunroof')->nullable();
            $table->boolean('phoneCharging')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softdeletes();

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
