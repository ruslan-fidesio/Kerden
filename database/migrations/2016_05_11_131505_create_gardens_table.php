<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gardens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->float('surface');
            $table->integer('max_pers');
            $table->string('address');
            $table->string('blur_address');
            $table->enum('state',['new','details_ok','dispo_ok','prices_ok','validated']);
            $table->timestamps();

            $table->foreign('userid')
                    ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gardens');
    }
}
