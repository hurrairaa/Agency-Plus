<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAvailabilityColumnsFromBasicSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->dropColumn(['is_service', 'is_portfolio', 'is_team', 'is_gallery', 'is_faq', 'is_blog', 'is_contact', 'is_quote']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->tinyInteger('is_service')->default(1);
            $table->tinyInteger('is_portfolio')->default(1);
            $table->tinyInteger('is_team')->default(1);
            $table->tinyInteger('is_gallery')->default(1);
            $table->tinyInteger('is_faq')->default(1);
            $table->tinyInteger('is_blog')->default(1);
            $table->tinyInteger('is_contact')->default(1);
            $table->tinyInteger('is_quote')->default(1);
        });
    }
}
