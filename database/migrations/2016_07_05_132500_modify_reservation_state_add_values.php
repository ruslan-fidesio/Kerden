<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyReservationStateAddValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE reservations MODIFY COLUMN transactionState ENUM('new','preAuth_ok','confirmed','canceledByUser','canceled','payIn_ok','done','refunded') ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE reservations MODIFY COLUMN transactionState ENUM('new','preAuth_ok','confirmed','canceled','payIn_ok','done') ");
    }
}
