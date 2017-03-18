<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMusicLevelAddLowerLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garden_music_levels', function (Blueprint $table) {
            //
            $table->boolean('lower_level_asked')->default(false);
            $table->integer('lower_level_hour');
            $table->enum('lower_level',['none','low','high','powerfull']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garden_music_levels', function (Blueprint $table) {
            $table->dropColumn(['lower_level_asked','lower_level_hour','lower_level']);
        });
    }
}
