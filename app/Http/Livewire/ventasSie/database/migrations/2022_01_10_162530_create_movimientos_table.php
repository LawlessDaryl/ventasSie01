<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();

            $table->enum('type',['PENDIENTE','PROCESO','TERMINADO','APERTURA','CIERRE','ANULADO','ENTREGADO','ABANDONADO','COMPRAS','VENTAS','DEVOLUCIONVENTA','ANULARVENTA'])->default('PENDIENTE');
            $table->enum('status',['ACTIVO','INACTIVO'])->default('ACTIVO');
            $table->decimal('saldo',10,2)->nullable();//Saldo que coloca el usuario al recepcionar el equipo
            $table->decimal('on_account',10,2)->nullable();
            $table->decimal('import',10,2)->default(0);//El importe final del servicio
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('movimientos');
    }
}
