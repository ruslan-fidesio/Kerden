<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyInfosLocAddGuestscansee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE garden_loc_infos MODIFY COLUMN type ENUM('DIGICODE','INTERPHONE','ETAGE','BATIMENT','USEPHONE','GUESTSCANSEE','AUTRE') ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
