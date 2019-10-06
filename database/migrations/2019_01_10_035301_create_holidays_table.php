<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('hasRange');
            $table->integer('startDate');
            $table->integer('endDate')->nullable();//->nullable();
            $table->boolean('yearSpecific');
            $table->integer('specificYear')->nullable();//->nullable();
            $table->unsignedInteger('month_id')->references('id')->on('months');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
