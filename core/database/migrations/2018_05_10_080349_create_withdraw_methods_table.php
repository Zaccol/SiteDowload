<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->float('min_limit', 10, 2)->nullable();
            $table->float('max_limit', 10, 2)->nullable();
            $table->float('fixed_charge', 8, 2)->nullable();
            $table->float('percentage_charge', 5, 2)->nullable();
            $table->string('process_time', 40)->nullable();
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
        Schema::dropIfExists('withdraw_methods');
    }
}
