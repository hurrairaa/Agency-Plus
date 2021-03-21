<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeroFonxSizeColsToBasicSettingsExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->integer('hero_section_title_font_size')->nullable();
            $table->integer('hero_section_bold_text_font_size')->nullable();
            $table->integer('hero_section_text_font_size')->nullable();
            $table->integer('hero_section_button_text_font_size')->nullable();
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
            $table->dropColumn(['hero_section_title_font_size', 'hero_section_bold_text_font_size', 'hero_section_text_font_size', 'hero_section_button_text_font_size']);
        });
    }
}
