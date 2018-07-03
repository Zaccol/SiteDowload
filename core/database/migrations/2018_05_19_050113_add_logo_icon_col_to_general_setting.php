<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogoIconColToGeneralSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_setting', function (Blueprint $table) {
          $table->string('logo')->nullable();
          $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_setting', function (Blueprint $table) {
            $table->dropColumn(['logo', 'icon']);
        });
    }
}
