<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRepEstadoSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rep_estado_solicituds', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('detalle_solicitud_id');
            $table->foreign('detalle_solicitud_id')->references('id')->on('service_rep_detalle_solicituds');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('status',100)->default('PENDIENTE');
            $table->enum('estado',['ACTIVO','INACTIVO'])->default('ACTIVO');
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
        Schema::dropIfExists('service_rep_estado_solicituds');
    }
}
