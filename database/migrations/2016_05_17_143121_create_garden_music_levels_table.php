<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenMusicLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_music_levels', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->enum('level',['none','low','high','powerfull']);
            $table->boolean('orchestar');

            $table->foreign('id')
                ->references('id')->on('gardens')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('garden_music_levels');
    }
}
