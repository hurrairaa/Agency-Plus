<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subtitle', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('details')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('type', 20)->default('manual');
            $table->mediumText('information')->nullable();
            $table->string('keyword', 255)->nullable();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
}
