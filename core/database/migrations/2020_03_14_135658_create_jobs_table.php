<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jcategory_id')->nullable();
            $table->integer('language_id')->default(0);
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->integer('vacancy')->nullable();
            $table->string('deadline', 255)->nullable();
            $table->string('experience', 255)->nullable();
            $table->binary('job_responsibilities')->nullable();
            $table->string('employment_status', 255)->nullable();
            $table->binary('educational_requirements')->nullable();
            $table->binary('experience_requirements')->nullable();
            $table->binary('additional_requirements')->nullable();
            $table->string('job_location', 255)->nullable();
            $table->binary('salary')->nullable();
            $table->binary('benefits')->nullable();
            $table->binary('read_before_apply')->nullable();
            $table->string('email', 255)->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
