<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->integer('importe');
            $table->date('plan_start');
            $table->date('expiration_plan');
            $table->integer('meses');
            $table->enum('ready', ['SI', 'NO'])->default('NO');
            $table->enum('done', ['SI', 'NO'])->default('NO');
            $table->enum('type_plan', ['CUENTA', 'PERFIL', 'COMBO']);
            $table->enum('status', ['VIGENTE', 'VENCIDO', 'ANULADO'])->default('VIGENTE');
            $table->enum('type_pay', ['EFECTIVO', 'Banco', 'TigoStreaming']);
            $table->string('observations')->nullable();
            $table->string('comprobante', 100)->nullable();
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
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
        Schema::dropIfExists('plans');
    }
}
