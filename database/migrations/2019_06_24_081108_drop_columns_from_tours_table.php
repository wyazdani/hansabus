<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('from_date');
            $table->dropColumn('to_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->string('from_date');
            $table->string('to_date');
        });
    }
}
