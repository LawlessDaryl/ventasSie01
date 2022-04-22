<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transferences', function (Blueprint $table) {
            
            $table->id();
            $table->string('observacion',250)->nullable();
            $table->enum('estado',['Activo','Inactivo'])->default('Activo');
            $table->unsignedBigInteger('id_destino');
            $table->foreign('id_destino')->references('id')->on('destinos');
            $table->unsignedBigInteger('id_origen');
            $table->foreign('id_origen')->references('id')->on('destinos');
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
        Schema::dropIfExists('transferences');
    }
}
