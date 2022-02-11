<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrigenMotivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origen_motivos', function (Blueprint $table) {
            $table->id();
            $table->enum('comision_si_no',['si','no','nopreguntar'])->default('no');
            $table->enum('afectadoSi',['montoR','montoC','ambos']);
            $table->enum('afectadoNo',['montoR','montoC','ambos']);
            $table->enum('suma_resta_si',['suma','resta','mantiene']);
            $table->enum('suma_resta_no',['suma','resta','mantiene']);
            $table->enum('CIdeCliente',['SI','NO'])->default('SI');
            $table->enum('telefSolicitante',['SI','NO'])->default('SI');
            $table->enum('telefDestino_codigo',['SI','NO'])->default('SI');
            $table->foreignId('origen_id')->constrained();
            $table->foreignId('motivo_id')->constrained();
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
        Schema::dropIfExists('origen_motivos');
    }
}
