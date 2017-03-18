<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMangoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mango_users', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->integer('mangoUserId')->unsigned()->unique();
            $table->integer('mangoWalletId')->unsigned()->unique();
            $table->timestamps();

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
        Schema::drop('mango_users');
    }
}
