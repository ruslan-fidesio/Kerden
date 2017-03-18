<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_activities', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->boolean('lunch')->default(false);
            $table->boolean('barbecue')->default(false);
            $table->boolean('reception')->default(false);
            $table->boolean('party')->default(false);
            $table->boolean('pro')->default(false);

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
        Schema::drop('garden_activities');
    }
}
