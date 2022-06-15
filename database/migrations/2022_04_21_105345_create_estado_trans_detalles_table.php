<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoTransDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_trans_detalles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estado_transferencias');

            $table->unsignedBigInteger('detalle_id');
            $table->foreign('detalle_id')->references('id')->on('detalle_transferencias');

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
        Schema::dropIfExists('estado_trans_detalles');
    }
}
