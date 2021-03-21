<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductHeidingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->string('product_title');
            $table->string('product_subtitle');
            $table->string('product_details_title');
            $table->string('product_details_subtitle');
            $table->string('cart_title');
            $table->string('cart_subtitle');
            $table->string('checkout_title');
            $table->string('checkout_subtitle');
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
            //
        });
    }
}
