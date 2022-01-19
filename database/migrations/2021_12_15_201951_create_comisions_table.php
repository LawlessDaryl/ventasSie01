<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',250);
            $table->string('tipo',250);
            $table->string('monto_a',250);
            $table->decimal('monto_inicial',10,2);
            $table->decimal('monto_final',10,2);
            $table->string('comision',250);
            $table->boolean('porcentaje');
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
        Schema::dropIfExists('comisions');
    }
}
