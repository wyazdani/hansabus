<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HireADriverAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hire_a_driver_attachments', function ($table) {

            $table->increments('id');
            $table->integer('hire_id')->unsigned()->nullable();
            $table->string('file')->default('')->nullable();
            $table->string('ext',10)->default('')->nullable();
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
        Schema::dropIfExists('hire_a_driver_attachments');
    }
}
