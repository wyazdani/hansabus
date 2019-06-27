<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHireADriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hire_a_driver', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('status', [1,2,3,4,5,6,7]);
            $table->bigInteger('customer_id')->default(0)->nullable();
            $table->bigInteger('driver_id')->default(0)->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->integer('price')->default(0)->nullable();

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
        Schema::dropIfExists('hire_a_driver');
    }
}
