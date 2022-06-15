<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255);
            $table->decimal('costo',10,2);
            $table->string('caracteristicas',255)->nullable();
            $table->string('codigo',45)->nullable();
            $table->string('lote',255)->nullable();
            $table->string('unidad')->nullable();
            $table->string('marca')->nullable();
            $table->integer('garantia')->nullable();
            $table->integer('cantidad_minima')->nullable()->default(0);
            $table->string('industria')->nullable();
            $table->decimal('precio_venta',10,2);
            $table->enum('status', ['ACTIVO','INACTIVO'])->default('ACTIVO');
            $table->string('image',55)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
