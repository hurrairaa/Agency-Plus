<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('billing_country');
            $table->string('billing_fname');
            $table->string('billing_lname');
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_email');
            $table->string('billing_number');
    

            $table->string('shpping_country');
            $table->string('shpping_fname');
            $table->string('shpping_lname');
            $table->string('shpping_address');
            $table->string('shpping_city');
            $table->string('shpping_email');
            $table->string('shpping_number');
  

            $table->decimal('total', 11, 2)->nullable();
            $table->string('method');
            $table->string('currency_code');
            $table->string('order_number');
            $table->decimal('shipping_charge', 11, 2)->nullable();
            $table->string('payment_status');
            $table->string('order_status')->default('pending');
            $table->string('txnid');
            $table->string('charge_id');
     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_orders');
    }
}
