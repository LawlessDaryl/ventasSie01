<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccions', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_transf');
            $table->decimal('importe',10,2);
            $table->decimal('utilidad',10,2);
            $table->decimal('costo',10,2);
            $table->string('observaciones',255)->nullable();
            $table->date('fecha_transaccion');
            $table->string('estado',255);
            $table->string('telefono',255);
            
            $table->unsignedBigInteger('origen_motivo_id');
            $table->foreign('origen_motivo_id')->references('id')->on('origen_motivos');
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
        Schema::dropIfExists('transaccions');
    }
}
