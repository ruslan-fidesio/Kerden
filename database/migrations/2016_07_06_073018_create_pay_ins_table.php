<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag');
            $table->integer('user_id')->unsigned();
            $table->string('mango_wallet_Id');
            $table->float('total_amount');
            $table->string('mango_preAuth_Id')->nullable();
            $table->string('mango_payIn_Id')->nullable();
            $table->string('mango_card_Id')->nullable();
            $table->string('status');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pay_ins');
    }
}
