<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->default(0);
            $table->string('name', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('short_text', 120)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('serial_number')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scategories');
    }
}
