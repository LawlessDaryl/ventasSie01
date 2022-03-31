<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_transferencias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transfererencia_id');
            $table->foreign('transferencia_id')->references('id')->on('transferencias');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('cantidad');

            $table->unsignedBigInteger('id_location');
            $table->foreign('id_location')->references('id')->on('locations');

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
        Schema::dropIfExists('detalle__transferencias');
    }
}
