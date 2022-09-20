<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarteraMovCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartera_mov_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('detalle', 255);
            $table->string('tipo', 10);
            $table->string('status', 10)->default('ACTIVO');
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
        Schema::dropIfExists('cartera_mov_categorias');
    }
}
