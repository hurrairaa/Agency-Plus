<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->text('products_meta_keywords')->nullable();
            $table->text('products_meta_description')->nullable();
            $table->text('cart_meta_keywords')->nullable();
            $table->text('cart_meta_description')->nullable();
            $table->text('checkout_meta_keywords')->nullable();
            $table->text('checkout_meta_description')->nullable();
            $table->text('login_meta_keywords')->nullable();
            $table->text('login_meta_description')->nullable();
            $table->text('register_meta_keywords')->nullable();
            $table->text('register_meta_description')->nullable();
            $table->text('forgot_meta_keywords')->nullable();
            $table->text('forgot_meta_description')->nullable();
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
            $table->dropColumn(['products_meta_keywords','products_meta_description','cart_meta_keywords','cart_meta_description','checkout_meta_keywords','checkout_meta_description','login_meta_keywords','login_meta_description','register_meta_keywords', 'register_meta_description', 'forgot_meta_keywords', 'forgot_meta_description']);
        });
    }
}
