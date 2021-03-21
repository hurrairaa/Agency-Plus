<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfflineGateways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->nullable();
            $table->string('name', '100')->nullable();
            $table->text('short_description')->nullable();
            $table->binary('instructions')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('is_receipt')->default(1);
            $table->string('receipt', 100)->nullable();
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
        Schema::dropIfExists('offline_gateways');
    }
}
