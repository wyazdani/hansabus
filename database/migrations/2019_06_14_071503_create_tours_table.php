<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tour_id')->default(0)->nullable();
            $table->bigInteger('driver_id')->default(0)->nullable();
            $table->bigInteger('customer_id')->default(0)->nullable();
            $table->string('tour_name')->nullable();
            $table->string('price')->nullable();
            $table->string('location')->nullable();
            $table->string('destination')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->softDeletes();

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
        Schema::dropIfExists('tours');
    }
}
