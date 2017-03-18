<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('garden_id')->unsigned();
            $table->integer('day');
            $table->integer('begin_slot');
            $table->integer('end_slot');

            $table->foreign('garden_id')
                    ->references('id')->on('gardens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('garden_hours');
    }
}
