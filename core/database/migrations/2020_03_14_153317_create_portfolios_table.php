<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->default(0);
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('start_date', 255)->nullable();
            $table->string('submission_date', 255)->nullable();
            $table->string('client_name', 255)->nullable();
            $table->text('tags')->nullable();
            $table->string('featured_image', 255)->nullable();
            $table->integer('service_id')->nullable();
            $table->binary('content')->nullable();
            $table->string('status', 20)->nullable();
            $table->integer('serial_number')->default(0);
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('portfolios');
    }
}
