<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_lotes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('salida_detalle_id');
            $table->foreign('salida_detalle_id')->references('id')->on('detalle_salida_productos');
            $table->foreignId('lote_id')->constrained();
            $table->integer('cantidad');
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
        Schema::dropIfExists('salida_lotes');
    }
}
