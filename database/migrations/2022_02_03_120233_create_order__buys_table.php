<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order__buys', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_orden');
            $table->date('fecha_recepcion');
            $table->decimal('monto_total');
            $table->decimal('fecha_factura');

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
        Schema::dropIfExists('order__buys');
    }
}
