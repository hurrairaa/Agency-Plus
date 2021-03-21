<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFontSizeColsToSliders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->integer('title_font_size')->after('title')->nullable();
            $table->string('bold_text', 255)->after('title_font_size')->nullable();
            $table->integer('bold_text_font_size')->after('bold_text')->nullable();
            $table->integer('text_font_size')->after('text')->nullable();
            $table->integer('button_text_font_size')->after('button_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['title_font_size', 'bold_text', 'bold_text_font_size', 'text_font_size', 'button_text_font_size']);
        });
    }
}
