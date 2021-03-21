<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_inputs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->default(0);
            $table->tinyInteger('type')->nullable()->comment('1-text, 2-select, 3-checkbox, 4-textarea, 5-file');
            $table->string('label', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('placeholder', 255)->nullable();
            $table->tinyInteger('required')->default(0)->comment('1 - required, 0 - optional');
            $table->tinyInteger('active')->default(1)->comment('0 - deactive, 1 - active');
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
        Schema::dropIfExists('quote_inputs');
    }
}
