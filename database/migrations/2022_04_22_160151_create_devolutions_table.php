<?php
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolutions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_devolucion')->default(Carbon::now());
            $table->enum('tipo',['compras','ventas']);  
            $table->enum('tipo_dev',['PRODUCTO','MONETARIO','PRODUCTO_MONETARIO']);

            $table->foreignId('sales_id')->constrained();
            $table->foreignId('compras_id')->constrained();
            $table->string('observations',200)->default('Sin Observacion')->nullable();
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
        Schema::dropIfExists('devolutions');
    }
}
