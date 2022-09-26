<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRepDetalleSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rep_detalle_solicituds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('service_rep_solicituds');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('cantidad');
            $table->enum('status',['Activo','Inactivo'])->default('Activo');
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
        Schema::dropIfExists('service_rep_detalle_solicituds');
    }
}
