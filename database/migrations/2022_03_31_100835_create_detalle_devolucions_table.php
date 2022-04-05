<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleDevolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_devolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_devolutions');
            $table->foreign('id_devolutions')->references('id')->on('devolutions');
            $table->unsignedBigInteger('product_id');//{mouse}
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('cantidad_dev');//{5}
           

            //registro de lo que  devuelvo
            $table->decimal('monto_dev');//{30}
            $table->unsignedBigInteger('product_id2');//{carcasas}
            $table->foreign('product_id2')->references('id')->on('products');
            $table->integer('cantidad_dev2');//{5}





           
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
        Schema::dropIfExists('detalle__devolucions');
    }
}
