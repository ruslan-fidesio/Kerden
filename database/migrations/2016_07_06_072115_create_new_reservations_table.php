<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('garden_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->dateTime('date_begin');
            $table->dateTime('date_end');
            $table->integer('nb_guests');
            $table->integer('nb_staff');
            $table->dateTime('staff_begin')->nullable();
            $table->boolean('owner_confirmed');
            $table->boolean('staff_confirmed');
            $table->text('description_by_user');
            $table->float('staff_amount');
            $table->float('location_amount');
            $table->float('total_amount');
            
            $table->string('payIn_Id')->nullable();
            $table->string('owner_transfert_Id')->nullable();
            $table->string('owner_payout_Id')->nullable();
            $table->string('staff_transfert_Id')->nullable();
            $table->string('staff_payout_Id')->nullable();
            $table->enum('status',['new','waiting_confirm','canceled_by_user','denied_by_owner','denied_by_staff','confirmed','done','refund_by_user','refund_by_owner']);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('garden_id')->references('id')->on('gardens');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservations');
    }
}
