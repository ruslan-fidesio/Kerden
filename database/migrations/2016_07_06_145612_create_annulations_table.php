<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annulations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservation_id')->unsigned();
            $table->enum('creator',['owner','user']);
            $table->integer('creator_id')->unsigned();
            $table->float('staff_transfert_amount');
            $table->float('owner_transfert_amount');
            $table->float('refund_amount');
            $table->float('fees');

            $table->integer('staff_transfert_Id')->unsigned();
            $table->integer('staff_payout_Id')->unsigned();

            $table->integer('owner_transfert_Id')->unsigned();
            $table->integer('owner_payout_Id')->unsigned();

            $table->integer('user_refund_Id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('annulations');
    }
}
