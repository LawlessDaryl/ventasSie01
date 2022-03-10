<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained();
            $table->string('codigo',100);
            $table->string('descripcion',250);
            $table->enum('ubicacion',['ALMACEN','TIENDA'])->default('ALMACEN');
            $table->enum('tipo',['VITRINA','MOSTRADOR','ESTANTE','OTRO'])->default('ESTANTE');
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
        Schema::dropIfExists('locations');
    }
}