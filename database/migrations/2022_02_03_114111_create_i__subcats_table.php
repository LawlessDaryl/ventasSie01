<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateISubcatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i__subcats', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->string('description',250);
            
            $table->timestamps();


            $table->foreign('i_category')->references('id')->on('i_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('i__subcats');
    }
}
