<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('employees');

            $table->decimal('anticipo',10,2);
            $table->string('motivo',500)->nullable();
            //$table->date('fecha');

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
        Schema::dropIfExists('anticipos');
    }
}
