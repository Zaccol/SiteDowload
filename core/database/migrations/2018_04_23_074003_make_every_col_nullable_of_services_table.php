<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEveryColNullableOfServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('service_title')->nullable()->change();
            $table->string('price')->nullable()->change();
            $table->integer('category_id')->nullable()->change();
            $table->string('max_days')->nullable()->change();
            $table->binary('description')->nullable()->change();
            $table->binary('intro_to_buyer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('service_title')->change();
            $table->string('price')->change();
            $table->integer('category_id')->change();
            $table->string('max_days')->change();
            $table->binary('description')->change();
            $table->binary('intro_to_buyer')->change();
        });
    }
}
