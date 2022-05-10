<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaInversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_inversions', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['EGRESO', 'INGRESO']);
            $table->decimal('cantidad', 10, 2);
            $table->enum('tipoPlan', ['ENTERA', 'PERFIL', 'COMBO'])->nullable();
            $table->enum('tipoTransac', ['COMPRA', 'VENTA', 'RENOVACION'])->nullable();
            $table->integer('num_meses');
            $table->dateTime('fecha_realizacion');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('cuenta_inversions');
    }
}
