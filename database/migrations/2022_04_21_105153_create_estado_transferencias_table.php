<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_transferencias', function (Blueprint $table) {
            $table->id();
            $table->enum('estado',['Pendiente','Aprobado','Rechazado','En transito','Recibido'])->default('Pendiente');
            $table->enum('op',['Activo','Inactivo'])->default('Activo');
            $table->unsignedBigInteger('id_transferencia');
            $table->foreign('id_transferencia')->references('id')->on('transferences');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('estado_transferencias');
    }
}
