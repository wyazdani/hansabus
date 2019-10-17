<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsBulkToDroverInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_invoice', function (Blueprint $table) {
            $table->tinyInteger('is_bulk')->nullable()->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_invoice', function (Blueprint $table) {
            $table->dropColumn('is_bulk');
        });
    }
}
