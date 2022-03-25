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
        Schema::create('movement_details', function (Blueprint $table) {
            $table->id();
           
            
            $table->unsignedBigInteger('id_movimiento');
            $table->foreign('id_movimiento')->references('id')->on('movement_inventories');
            
          
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');


            $table->integer('cantidad');
            $table->decimal('costo');          
            
            $table->unsignedBigInteger('id_location');
            $table->foreign('id_location')->references('id')->on('locations');
            
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
