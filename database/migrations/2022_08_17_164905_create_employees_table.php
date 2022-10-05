<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('ci',255)->unique();
            $table->string('name',255);
            $table->string('lastname',255);
            $table->enum('genero',['Masculino','Femenino'])->default('Masculino'); // seleccionar genero
            $table->date('dateNac');    // fecha de nacimiento
            $table->string('address',255);
            $table->string('phone');
            $table->enum('estadoCivil',['Soltero','Casado'])->default('Soltero');

            $table->unsignedBigInteger('area_trabajo_id');
            $table->foreign('area_trabajo_id')->references('id')->on('area_trabajos');

            $table->unsignedBigInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos');

            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')->on('contratos');

            $table->timestamp('fechaInicio');
            $table->string('image',100)->nullable();

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
        Schema::dropIfExists('employees');
    }
}
