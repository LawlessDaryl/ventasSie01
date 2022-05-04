<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product');
            $table->foreign('product')->references('id')->on('products');
            
            $table->unsignedBigInteger('location');
            $table->foreign('location')->references('id')->on('locations');
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
        Schema::dropIfExists('location_productos');
    }
}
