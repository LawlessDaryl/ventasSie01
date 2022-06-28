<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCatProdServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_cat_prod_services', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->decimal('price',10,2)->default(0);
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');

            $table->unsignedBigInteger('cat_prod_service_id');
            $table->foreign('cat_prod_service_id')->references('id')->on('cat_prod_services');

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
        Schema::dropIfExists('sub_cat_prod_services');
    }
}
