<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsInVehicleTable extends Migration
{
    public function __construct()
    {
        \Illuminate\Support\Facades\DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->string('name',150)->nullable()->change();
            $table->string('year',4)->nullable()->change();
            $table->string('make',100)->nullable()->change();
            $table->string('engineNumber',100)->nullable()->change();
            $table->string('licensePlate',50)->nullable()->change();
            $table->integer('seats')->default(0)->change();
            $table->string('color')->nullable()->change();
            $table->string('registrationNumber',100)->nullable()->change();
            $table->boolean('AC')->default(0)->change();
            $table->boolean('radio')->default(0)->change();
            $table->boolean('sunroof')->default(0)->change();
            $table->boolean('phoneCharging')->default(0)->change();
            $table->boolean('status')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->string('name',150)->change();
            $table->string('year',4)->change();
            $table->string('make',100)->change();
            $table->string('engineNumber',100)->change();;
            $table->string('licensePlate',50)->change();
            $table->integer('seats')->change();
            $table->string('color')->change();

            $table->string('registrationNumber',100)->change();
            $table->boolean('AC')->change();
            $table->boolean('radio')->change();
            $table->boolean('sunroof')->change();
            $table->boolean('phoneCharging')->change();
            $table->boolean('status')->change();
        });
    }
}
