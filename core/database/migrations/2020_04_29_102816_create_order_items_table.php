<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_order_id')->nullable;
            $table->integer('product_id')->nullable;
            $table->integer('user_id')->nullable;
            $table->string('title')->nullable;
            $table->string('sku')->nullable;
            $table->integer('qty')->nullable;
            $table->string('category')->nullable;
            $table->string('image')->nullable;
            $table->text('summary')->nullable;
            $table->text('description')->nullable;
            $table->decimal('price', 11, 2)->nullable();
            $table->decimal('previous_price', 11, 2)->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
