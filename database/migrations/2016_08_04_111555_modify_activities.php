<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garden_activities', function (Blueprint $table) {
            $table->boolean('relax')->default(false);
            $table->boolean('children')->default(false);
            $table->boolean('nightEvent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garden_activities', function (Blueprint $table) {
            $table->dropColumn(['relax','children','nightEvent']);
        });
    }
}
