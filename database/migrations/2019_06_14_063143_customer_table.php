<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

    Schema::create('customer', function ($table) {

        $table->increments('id')->unsigned();
        $table->string('name',200)->nullable();
        $table->string('email')->unique()->nullable();
        $table->string('url',200)->nullable();
        $table->string('phone',15)->nullable();
        $table->string('address',200)->nullable();
        $table->boolean('status')->nullable();
        $table->timestamps();
        $table->softdeletes();


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
        Schema::dropIfExists('customer');
    }
}
