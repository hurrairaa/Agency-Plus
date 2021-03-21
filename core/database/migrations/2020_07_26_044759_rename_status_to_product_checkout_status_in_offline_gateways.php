<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStatusToProductCheckoutStatusInOfflineGateways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_gateways', function (Blueprint $table) {
            $table->renameColumn('status', 'product_checkout_status');
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
            $table->renameColumn('product_checkout_status', 'status');
        });
    }
}
