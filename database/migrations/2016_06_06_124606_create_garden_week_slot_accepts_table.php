<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenWeekSlotAcceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_week_slot_accepts', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->boolean('morning');
            $table->boolean('afternoon');
            $table->boolean('evening');
            $table->boolean('night');

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
        Schema::drop('garden_week_slot_accepts');
    }
}
