<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_invoice', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->integer('customer_id')->unsigned();
            $table->integer('total')->unsigned();
            $table->enum('status', [1,2]); // 1=un-paid, 2=paid

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
        Schema::dropIfExists('tour_invoice');
    }
}
