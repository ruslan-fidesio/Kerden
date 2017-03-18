<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->bigInteger('birthday');
            $table->string('nationality')->default('FR');
            $table->string('countryOfResidence');
            $table->string('addressLine1');
            $table->string('addressLine2')->nullable();
            $table->string('addressCity');
            $table->string('addressPostalCode');
            $table->string('addressCountry');
            $table->string('occupation')->nullable();
            $table->tinyInteger('incomeRange')->nullable();
            $table->string('proofOfIdentity')->nullable();
            $table->enum('type',['natural','legal'])->default('natural');
            $table->bigInteger('organization')->unsigned()->nullable();
            $table->timestamps();

            //indexes
            $table->primary('id');
            $table->foreign('id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->foreign('nationality')
                    ->references('alpha2')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_details');
    }
}
