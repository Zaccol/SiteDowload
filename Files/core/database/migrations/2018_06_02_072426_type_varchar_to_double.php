<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TypeVarcharToDouble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->float('minamo', 10, 2)->nullable()->change();
            $table->float('maxamo', 10, 2)->nullable()->change();
            $table->float('chargefx', 10, 2)->nullable()->change();
            $table->float('chargepc', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->string('minamo')->nullable()->change();
            $table->string('maxamo')->nullable()->change();
            $table->string('chargefx')->nullable()->change();
            $table->string('chargepc')->nullable()->change();
        });
    }
}
