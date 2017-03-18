<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGardensAddOwnerMasked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gardens', function (Blueprint $table) {
            $table->boolean('owner_masked')->after('state')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gardens', function (Blueprint $table) {
            $table->dropColumn('owner_masked');
        });
    }
}
