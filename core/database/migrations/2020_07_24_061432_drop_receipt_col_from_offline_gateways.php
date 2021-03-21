<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReceiptColFromOfflineGateways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_gateways', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_gateways', function (Blueprint $table) {
            $table->string('receipt', 100)->nullable();
        });
    }
}
