<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_sales', function (Blueprint $table) {
            $table->id();
            $table->string('nameclient',100);
            $table->string('phone',12);
            $table->string('idaccount',50);
            $table->string('alias', 50);
            $table->string('observation',500)->default('Ninguna');
            $table->unsignedBigInteger('free_plan_id');
            $table->foreign('free_plan_id')->references('id')->on('free_plans');
            $table->unsignedBigInteger('sucursals_id');
            $table->foreign('sucursals_id')->references('id')->on('sucursals');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('movimiento_id')->references('id')->on('movimientos');
            $table->unsignedBigInteger('cartera_id');
            $table->foreign('cartera_id')->references('id')->on('carteras');
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
        Schema::dropIfExists('free_sales');
    }
}
