<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyReservationState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE reservations MODIFY COLUMN transactionState ENUM('new','preAuth_ok','confirmed','canceled','payIn_ok','done') ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE reservations MODIFY COLUMN transactionState ENUM('new','preAuth_ok','confirmed','canceled','payIn_ok') ");
    }
}
