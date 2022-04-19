<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencia_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transferencia');
            $table->foreign('id_transferencia')->references('id')->on('transferences');
            $table->unsignedBigInteger('id_detalle');
            $table->foreign('id_detalle')->references('id')->on('detalle_transferencias');
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
        Schema::dropIfExists('transferencia_detalles');
    }
}
