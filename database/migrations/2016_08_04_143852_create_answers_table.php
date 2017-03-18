<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commentaire_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('content');
            $table->boolean('reported');
            $table->boolean('denied');
            $table->timestamps();

            $table->foreign('commentaire_id')
                ->references('id')->on('commentaires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answers');
    }
}
