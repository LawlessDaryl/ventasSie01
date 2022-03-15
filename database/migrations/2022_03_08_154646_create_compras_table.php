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
            $table->dateTime('fecha_compra')->default(Carbon::now());
            $table->enum('impuestos',['EXENTO','FACTURADO','P'])->default('P');
            $table->enum('pago',['PENDIENTE DE PAGO','PAGADO','P'])->default('P');
            $table->decimal('saldo_por_pagar',10,2)->default(0);
            $table->enum('tipo_doc',['FACTURA','COMPROBANTE','NOTA DE VENTA','P'])->default('P');
            $table->string('nro_documento',100)->nullable();
            $table->string('observacion',100)->nullable();
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('providers');
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
