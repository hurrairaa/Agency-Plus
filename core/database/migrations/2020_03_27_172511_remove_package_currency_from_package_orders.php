<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePackageCurrencyFromPackageOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_orders', function (Blueprint $table) {
            $table->dropColumn('package_currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_orders', function (Blueprint $table) {
            $table->string('package_currency', 20)->nullable();
        });
    }
}
