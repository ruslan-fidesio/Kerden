<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenToiletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_toilets', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->integer('wc_in');
            $table->integer('wc_out');

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
        Schema::drop('garden_toilets');
    }
}
