<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenGuidelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_guidelines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('garden_id')->unsigned();
            $table->text('message');
            $table->timestamps();

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
        Schema::drop('garden_guidelines');
    }
}
