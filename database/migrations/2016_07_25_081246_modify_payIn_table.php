<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPayInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay_ins', function (Blueprint $table) {
            $table->dropColumn('mango_preAuth_Id');
            $table->dropColumn('mango_card_Id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay_ins', function (Blueprint $table) {
            //
        });
    }
}
