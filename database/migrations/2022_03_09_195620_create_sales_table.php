<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total',10,2);
            $table->integer('items');
            $table->decimal('cash',10,2);
            $table->decimal('change',10,2);
            $table->enum('status',['PAID','PENDING','CANCELED'])->default('PAID');
            $table->string('tipopago',20);
            $table->string('factura',2);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
            $table->unsignedBigInteger('cartera_id');
            $table->foreign('cartera_id')->references('id')->on('carteras');
            $table->string('observacion',500)->default('Ninguna');

            // $table->unsignedBigInteger('destinoproducto_id');
            // $table->foreign('destinoproducto_id')->references('id')->on('destinoproducto');


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
        Schema::dropIfExists('sales');
    }
}
