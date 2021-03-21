<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->nullable();
            $table->string('feed_name', 255)->nullable();
            $table->string('feed_url', 255)->nullable();
            $table->integer('post_limit')->nullable();
            $table->tinyInteger('auto_update')->default(0);
            $table->string('read_more_button', 30)->nullable();
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
        Schema::dropIfExists('rss_feeds');
    }
}
