<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->date('start_account');
            $table->date('expiration_account');
            $table->enum('status', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->enum('whole_account', ['ENTERA', 'DIVIDIDA'])->default('ENTERA');
            $table->integer('number_profiles');
            $table->string('account_name', 50);
            $table->string('password_account', 20);
            $table->decimal('price', 10, 2);
            $table->enum('availability', ['LIBRE', 'OCUPADO'])->default('LIBRE');
            $table->integer('meses_comprados');
            $table->unsignedBigInteger('str_supplier_id');
            $table->foreign('str_supplier_id')->references('id')->on('str_suppliers');
            $table->unsignedBigInteger('platform_id');
            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->unsignedBigInteger('email_id')->nullable();
            $table->foreign('email_id')->references('id')->on('emails');
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
        Schema::dropIfExists('accounts');
    }
}
