<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBreadcrumbsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->string('product_title', 255)->nullable()->change();
            $table->string('product_subtitle', 255)->nullable()->change();
            $table->string('product_details_title', 255)->nullable()->change();
            $table->string('cart_title', 255)->nullable()->change();
            $table->string('cart_subtitle', 255)->nullable()->change();
            $table->string('checkout_title', 255)->nullable()->change();
            $table->string('checkout_subtitle', 255)->nullable()->change();
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
            $table->dropColumn(['product_title', 'product_subtitle', 'product_details_title', 'product_details_subtitle', 'cart_title', 'cart_subtitle', 'checkout_title', 'checkout_subtitle']);
        });
    }
}
