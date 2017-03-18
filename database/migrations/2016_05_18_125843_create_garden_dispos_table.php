<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenDisposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_dispos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('garden_id')->unsigned();
            $table->bigInteger('date');
            $table->enum('dispo',['auto','manual']);

            $table->foreign('garden_id')
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
        Schema::drop('garden_dispos');
    }
}
