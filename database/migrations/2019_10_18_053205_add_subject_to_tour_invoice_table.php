<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectToTourInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_invoice', function (Blueprint $table) {
            $table->string('subject')->nullable()->after('is_bulk');
            $table->text('body')->nullable()->after('is_bulk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_invoice', function (Blueprint $table) {
            $table->dropColumn('subject');
            $table->dropColumn('body');
        });
    }
}
