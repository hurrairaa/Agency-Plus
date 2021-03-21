<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntroAndPricingOverlayCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->string('intro_overlay_color', 20)->nullable()->after('cta_overlay_opacity');
            $table->decimal('intro_overlay_opacity', 8, 2)->nullable()->after('intro_overlay_color');
            $table->string('pricing_overlay_color', 20)->nullable()->after('intro_overlay_opacity');
            $table->decimal('pricing_overlay_opacity', 8, 2)->nullable()->after('pricing_overlay_color');
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
            $table->dropColumn(['intro_overlay_color', 'intro_overlay_opacity', 'pricing_overlay_color', 'pricing_overlay_opacity']);
        });
    }
}
