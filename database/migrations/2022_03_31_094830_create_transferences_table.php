<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transferences', function (Blueprint $table) {
            
            $table->id();
            $table->dateTime('fecha_transferencia')->default(Carbon::now());
<<<<<<< HEAD
            $table->enum('status',['Pendiente','Aprobado','Rechazado','Faltante','Entregado'])->default('Pendiente');
            $table->enum('estado',['Activo','Inactivo'])->default('Activo');
=======
            $table->enum('status',['Pendiente','Aprobado','Rechazado','Entregado'])->default('Pendiente');
>>>>>>> 72224b0b0b33a2734488900c9f249c3ac5a52b9d
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
        Schema::dropIfExists('transferences');
    }
}
