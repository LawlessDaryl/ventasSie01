<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolutionSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolution_sales', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_dev',['PRODUCTO','MONETARIO']);
            $table->decimal('monto_dev',10,2);
            $table->string('observations',200)->default('Sin Observacion')->nullable();
            $table->enum('estado',['NORMAL','ELIMINADO','TRANSFERIDO'])->default('NORMAL');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('devolution_sales');
    }
}
