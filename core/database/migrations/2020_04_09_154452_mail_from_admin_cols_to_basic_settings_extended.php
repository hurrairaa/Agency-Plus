<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailFromAdminColsToBasicSettingsExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->string('from_name', 255)->nullable();
            $table->tinyInteger('is_smtp')->default(0);
            $table->string('smtp_host', 255)->nullable();
            $table->string('smtp_port', 30)->nullable();
            $table->string('smtp_encryption', 30)->nullable();
            $table->string('smtp_username', 255)->nullable();
            $table->string('smtp_password', 255)->nullable();
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
            $table->dropColumn(['from_name','is_smtp','smtp_host','smtp_port','smtp_encryption','smtp_username','smtp_password']);
        });
    }
}
