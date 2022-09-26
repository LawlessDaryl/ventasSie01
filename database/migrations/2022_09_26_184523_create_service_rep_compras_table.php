<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRepComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rep_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compra_id');
            $table->foreign('compra_id')->references('id')->on('compras');
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('service_rep_solicituds');
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
        Schema::dropIfExists('service_rep_compras');
    }
}
