<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
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
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('garden_id')->unsigned();
            $table->bigInteger('date');
            $table->integer('slot_begin');
            $table->integer('slot_end');
            $table->integer('nb_guests');

            $table->integer('nb_staff');
            $table->integer('staff_slot_begin');
            $table->integer('staff_slot_end');

            $table->boolean('staff_confirmed');
            $table->boolean('owner_confirmed');

            $table->bigInteger('preAuthorizationId');
            $table->float('total_amount');
            $table->float('staff_amount');

            $table->text('description_by_user');

            $table->foreign('user_id')
                    ->references('id')->on('users');

            $table->foreign('garden_id')
                    ->references('id')->on('gardens');

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
