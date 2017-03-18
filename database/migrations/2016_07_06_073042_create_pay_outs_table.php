<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_outs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('tag');
            $table->string('bankWireRef');

            $table->integer('user_id')->unsigned();
            $table->string('mango_user_Id');
            $table->string('mango_debited_wallet_Id');
            $table->string('mango_banck_account_Id');
            $table->float('amount');
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
        Schema::drop('pay_outs');
    }
}
