<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeatureToScategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scategories', function (Blueprint $table) {
            $table->tinyInteger('feature')->default(0)->comment('0 - will not show in home, 1 - will show in home');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scategories', function (Blueprint $table) {
            $table->dropColumn('feature');
        });
    }
}
