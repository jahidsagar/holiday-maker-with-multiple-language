<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_holidays', function (Blueprint $table) {
            $table->unsignedInteger('description_id');
            $table->unsignedInteger('holiday_id');
            $table->foreign('description_id')->references('id')->on('descriptions');
            $table->foreign('holiday_id')->references('id')->on('holidays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('description_holidays');
    }
}
