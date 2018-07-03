<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecColorToGeneralSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_setting', function (Blueprint $table) {
            $table->string('sec_color_code')->nullable()->after('base_color_code');
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
            $table->dropColumn('sec_color_code');
        });
    }
}
