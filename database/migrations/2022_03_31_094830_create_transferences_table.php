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
            $table->enum('status',['Pendiente','En transito','Aprobado','Rechazado','Faltante','Recibido'])->default('Pendiente');
            $table->enum('estado',['Activo','Inactivo'])->default('Activo');
            $table->string('observacion',250);
            $table->string('referencia',100);
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
