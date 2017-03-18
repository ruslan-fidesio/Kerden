<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGardenRequiredStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garden_required_staffs', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique();
            $table->integer('requiredStaff');
            $table->boolean('requiredStaffNight');
            $table->boolean('restrictedKitchenAccess');

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
        Schema::drop('garden_required_staffs');
    }
}
