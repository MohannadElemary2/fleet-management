<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('start_city_id');
            $table->unsignedBigInteger('destination_city_id');
            $table->integer('order')->index();

            $table->timestamps();
            $table->softDeletes();

            // relations
            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('start_city_id')->references('id')->on('cities');
            $table->foreign('destination_city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paths');
    }
}
