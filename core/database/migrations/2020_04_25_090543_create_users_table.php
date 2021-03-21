<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('photo')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('number')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('remember_token')->nullable();
            
            $table->string('billing_fname')->nullable();
            $table->string('billing_lname')->nullable();
            $table->string('billing_photo')->nullable();
            $table->string('billing_username')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_number')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_country')->nullable();

            $table->string('shpping_fname')->nullable();
            $table->string('shpping_lname')->nullable();
            $table->string('shpping_photo')->nullable();
            $table->string('shpping_username')->nullable();
            $table->string('shpping_email')->nullable();
            $table->string('shpping_number')->nullable();
            $table->string('shpping_city')->nullable();
            $table->string('shpping_state')->nullable();
            $table->string('shpping_address')->nullable();
            $table->string('shpping_country')->nullable();

            
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
        Schema::dropIfExists('users');
    }
}
