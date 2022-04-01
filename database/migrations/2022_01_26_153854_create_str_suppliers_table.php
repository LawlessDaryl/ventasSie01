<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('str_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone');
            $table->string('mail')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('str_suppliers');
    }
}
