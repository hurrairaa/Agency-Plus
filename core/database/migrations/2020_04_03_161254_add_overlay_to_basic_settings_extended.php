<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOverlayToBasicSettingsExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->string('hero_overlay_color', 20)->nullable();
            $table->decimal('hero_overlay_opacity', 2, 2)->nullable();
            $table->string('statistics_overlay_color', 20)->nullable();
            $table->decimal('statistics_overlay_opacity', 2, 2)->nullable();
            $table->string('team_overlay_color', 20)->nullable();
            $table->decimal('team_overlay_opacity', 2, 2)->nullable();
            $table->string('cta_overlay_color', 20)->nullable();
            $table->decimal('cta_overlay_opacity', 2, 2)->nullable();
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
            $table->dropColumn(['hero_overlay_color', 'hero_overlay_opacity', 'statistics_overlay_color', 'statistics_overlay_opacity', 'team_overlay_color', 'team_overlay_opacity', 'cta_overlay_color', 'cta_overlay_opacity']);
        });
    }
}
