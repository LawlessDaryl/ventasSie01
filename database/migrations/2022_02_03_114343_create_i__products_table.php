<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i__products', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->decimal('cost');
            $table->decimal('sale_Prices');
            $table->string('barcode',100);
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->foreign('i_category')->references('id')->on('i_categories');
            $table->foreign('i_subcats')->references('id')->on('i_subcats');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('i__products');
    }
}
