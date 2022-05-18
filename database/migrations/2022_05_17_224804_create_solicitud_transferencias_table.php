<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_transferencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origen_sol');
            $table->foreign('origen_sol')->references('id')->on('destinos');
            $table->unsignedBigInteger('destino_sol');
            $table->foreign('destino_sol')->references('id')->on('destinos');
            $table->softDeletes();
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
        Schema::dropIfExists('solicitud_transferencias');
    }
}
