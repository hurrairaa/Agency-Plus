<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseOpacityColLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->decimal('hero_overlay_opacity', 8, 2)->nullable()->change();
            $table->decimal('statistics_overlay_opacity', 8, 2)->nullable()->change();
            $table->decimal('team_overlay_opacity', 8, 2)->nullable()->change();
            $table->decimal('cta_overlay_opacity', 8, 2)->nullable()->change();
            $table->decimal('breadcrumb_overlay_opacity', 8, 2)->nullable()->change();
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
            $table->decimal('hero_overlay_opacity', 2, 2)->nullable()->change();
            $table->decimal('statistics_overlay_opacity', 2, 2)->nullable()->change();
            $table->decimal('team_overlay_opacity', 2, 2)->nullable()->change();
            $table->decimal('cta_overlay_opacity', 2, 2)->nullable()->change();
            $table->decimal('breadcrumb_overlay_opacity', 2, 2)->nullable()->change();
        });
    }
}
