<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarteraMovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartera_movs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['EGRESO', 'INGRESO', 'APERTURA', 'CIERRE']);
            $table->enum('tipoDeMovimiento', ['EGRESO/INGRESO', 'CORTE', 'TIGOMONEY', 'STREAMING', 'SERVICIOS', 'VENTA', 'COMPRA']);
            $table->string('comentario', 255);
            $table->unsignedBigInteger('cartera_id');
            $table->foreign('cartera_id')->references('id')->on('carteras');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
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
        Schema::dropIfExists('cartera_movs');
    }
}
