<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseCurrencyColumnsToBasicSettingsExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            $table->binary('base_currency_symbol')->nullable();
            $table->string('base_currency_symbol_position', 10)->default('left');
            $table->string('base_currency_text', 100)->nullable();
            $table->string('base_currency_text_position', 10)->default('right');
            $table->decimal('base_currency_rate', 8, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            $table->dropColumn(['base_currency_symbol','base_currency_symbol_position','base_currency_text','base_currency_text_position','base_currency_rate']);
        });
    }
}
