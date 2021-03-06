<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailConfirmationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_confirmations', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->string('token');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('id')
                    ->references('id')->on('users')
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
        Schema::drop('mail_confirmations');
    }
}
