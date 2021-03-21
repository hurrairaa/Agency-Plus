<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('fields')->nullable();
            $table->string('nda', 255)->nullable();
            $table->string('package_title', 255)->nullable();
            $table->string('package_currency', 20)->nullable();
            $table->decimal('package_price', 11, 2)->nullable();
            $table->binary('package_description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0-pending, 1-prcessing, 2-completed, 3-rejected');
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
        Schema::dropIfExists('package_orders');
    }
}
