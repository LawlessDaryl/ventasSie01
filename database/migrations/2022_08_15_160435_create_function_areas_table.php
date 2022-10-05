<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('function_areas', function (Blueprint $table) {
            $table->id();

            $table->string('name',255);
            $table->string('description',500)->nullable();

            $table->unsignedBigInteger('area_trabajo_id');
            $table->foreign('area_trabajo_id')->references('id')->on('area_trabajos');

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
        Schema::dropIfExists('function_areas');
    }
}
