<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement__details', function (Blueprint $table) {
            $table->id();

            $table->integer('cantidad');
            $table->decimal('costo');
            $table->decimal('subtotal');
            
            $table->foreign('id_producto')->references('id')->on('i_products');

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
        Schema::dropIfExists('movement__details');
    }
}
