<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seller_id')->nullable();
            $table->integer('buyer_id')->nullable();
            $table->integer('service_id')->nullable();
            // the order is taken or not...
            $table->integer('taken')->nullable();
            //buyer decision is accepted or not...
            $table->integer('seller_status')->nullable();
            // buyer has accepted the delivery or not...
            $table->integer('buyer_status')->nullable();
            // the project is completed(2) or current(1) or pending(0)
            $table->integer('status')->nullable();
            $table->float('money', 8, 2)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
