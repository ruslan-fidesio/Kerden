<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyKitchenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garden_kitchens', function (Blueprint $table) {
            $table->dropColumn(['type','surface']);
            $table->boolean('indoor');
            $table->float('indoor_surface');
            $table->boolean('outdoor');
            $table->float('outdoor_surface');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garden_kitchens', function (Blueprint $table) {
            //
        });
    }
}
