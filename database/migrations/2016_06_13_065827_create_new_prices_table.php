<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_prices', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->float('weekDay');
            $table->float('weekEnd');

            $table->foreign('id')
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
        Schema::drop('garden_prices');
    }
}
