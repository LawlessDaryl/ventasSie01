<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table)
        {
            $table->id();
            $table->decimal('importe_total',10,2)->nullable();
            $table->decimal('descuento',10,2)->nullable();
            $table->dateTime('fecha_compra')->default(Carbon::now());
           
            $table->enum('transaccion',['Credito','Contado','P'])->default('Contado');
            $table->decimal('pago',10,2)->default(0);
            $table->enum('tipo_doc',['FACTURA','NOTA DE VENTA','RECIBO','NINGUNO'])->default('FACTURA');
            $table->string('nro_documento',100)->nullable();
            $table->string('observacion',100)->nullable();
            
            
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('providers');
            $table->enum('estado_compra',['finalizada','no_finalizada','P']);
            $table->enum('status',['ACTIVO','INACTIVO','P'])->default('ACTIVO');
            $table->foreignId('destino_id')->constrained();
            $table->softDeletes();
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
        Schema::dropIfExists('compras');
    }
}
