<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStatusColsInOfflineGateways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_gateways', function (Blueprint $table) {
            $table->integer('product_checkout_status')->default(0)->change();
            $table->tinyInteger('package_order_status')->default(0);
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
            $table->tinyInteger('product_checkout_status')->default(1)->change();
            $table->dropColumn('package_order_status');
        });
    }
}
