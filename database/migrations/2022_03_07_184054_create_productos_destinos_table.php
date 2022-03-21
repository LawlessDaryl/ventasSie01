<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosDestinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_destinos', function (Blueprint $table) {
      

            $table->unsignedBigInteger('product-id');
            $table->foreign('product-id')->references('id')->on('products');
            
            $table->unsignedBigInteger('destino-id');
            $table->foreign('destino-id')->references('id')->on('locations');
            
            $table->integer('stock');
            
            $table->string('alertas');

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
        Schema::dropIfExists('productos_destinos');
    }
}
