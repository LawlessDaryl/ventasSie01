<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255)->nullable();
            $table->string('cedula',10)->default(0);
            $table->string('celular',10)->default(0);
            $table->string('direccion',255)->nullable();
            $table->string('email',100)->nullable();
            $table->date('fecha_nacim')->nullable();
            $table->string('razon_social')->nullable();
            $table->integer('nit')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
