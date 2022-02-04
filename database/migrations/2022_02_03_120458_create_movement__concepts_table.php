<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementConceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement__concepts', function (Blueprint $table) {
            $table->id();
            $table->enum('Operation_type',['Compra productos','Venta Productos','Transferencia de productos','Devolucion de productos'])->default('Buy_Operation');
            $table->string('Observations',250);
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
        Schema::dropIfExists('movement__concepts');
    }
}
