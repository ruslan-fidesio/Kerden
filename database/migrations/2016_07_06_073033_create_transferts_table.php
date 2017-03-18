<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('debited_user_Id')->unsigned();
            $table->string('mango_debited_user_Id');
            $table->string('mango_debited_wallet_Id');
            
            $table->integer('credited_user_Id')->unsigned();
            $table->string('mango_credited_user_Id');
            $table->string('mango_credited_wallet_Id');

            $table->float('amount');
            $table->float('fees');

            $table->string('status');

            $table->timestamps();

            $table->foreign('debited_user_Id')->references('id')->on('users');
            $table->foreign('credited_user_Id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transferts');
    }
}
