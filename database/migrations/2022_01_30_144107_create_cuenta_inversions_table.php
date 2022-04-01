<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaInversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_inversions', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('expiration_date');
            $table->decimal('price', 10, 2);
            $table->integer('number_profiles');
            $table->enum('status', ['ACTIVO', 'PASADA'])->default('ACTIVO');

            $table->enum('type', ['CUENTA', 'PERFILES'])->nullable();            
            $table->integer('sale_profiles')->nullable();
            $table->integer('imports')->nullable();
            $table->integer('ganancia')->nullable();
            
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('cuenta_inversions');
    }
}
