<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salida_id');
            $table->foreign('salida_id')->references('id')->on('salida_productos');
            $table->foreignId('service_id')->constrained();
            $table->enum('estado',['Activo','Inactivo'])->default('Activo');
            $table->decimal('precio_venta',10,2);
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
        Schema::dropIfExists('salida_servicios');
    }
}
