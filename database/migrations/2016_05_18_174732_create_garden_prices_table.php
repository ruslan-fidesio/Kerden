<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_prices', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->float('morning');
            $table->float('afternoon');
            $table->float('evening');
            $table->float('night');
            $table->integer('hour_max');

            $table->foreign('id')
                ->references('id')->on('gardens')
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
        Schema::drop('garden_prices');
    }
}
