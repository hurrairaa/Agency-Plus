<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicSettingsExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_settings_extra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->default(1);
            $table->tinyInteger('is_shop')->default(1);
            $table->tinyInteger('is_ticket')->default(1);
            $table->tinyInteger('is_user_panel')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basic_settings_extra');
    }
}
