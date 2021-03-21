<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->default(0);
            $table->string('name', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->binary('body')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('pages');
    }
}
