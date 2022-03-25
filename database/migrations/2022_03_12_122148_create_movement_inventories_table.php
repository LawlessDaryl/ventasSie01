<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateMovementInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_inventories', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['entrada','salida']);  
            $table->enum('operacion',['devolucion','ajuste','transferencia','compra','venta']);  
            $table->dateTime('fecha_movimiento')->default(Carbon::now());
            $table->unsignedBigInteger('id_compra');
            $table->foreign('id_compra')->references('id')->on('compras');
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_venta')->references('id')->on('sales');
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
        Schema::dropIfExists('movement__inventories');
    }
}
