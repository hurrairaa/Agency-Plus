<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAvailabilityColumnsFromBasicSettingsExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->dropColumn(['is_order_package', 'is_packages', 'is_career', 'is_calendar', 'is_rss']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->tinyInteger('is_order_package')->default(1);
            $table->tinyInteger('is_packages')->default(1);
            $table->tinyInteger('is_career')->default(1);
            $table->tinyInteger('is_calendar')->default(1);
            $table->tinyInteger('is_rss')->default(1);
        });
    }
}
