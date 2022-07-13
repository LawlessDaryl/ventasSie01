<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_salidas', function (Blueprint $table) {
            $table->id();
            $table->enum('proceso',['Entrada','Salida']);
            $table->unsignedBigInteger('destino');
            $table->foreign('destino')->references('id')->on('destinos');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('concepto',['INGRESOEGRESO','AJUSTE','INICIAL']);
            $table->string('observacion',500);
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
        Schema::dropIfExists('ingreso_salidas');
    }
}