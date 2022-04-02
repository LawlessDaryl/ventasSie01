<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable=['importe_total','fecha_compra','impuestos','transaccion','saldo_por_pagar','tipo_doc','nro_documento','observacion','metodo_pago','proveedor_id','status','estado_compra'];
    
    public function compradetalle()
    {
        return $this->hasMany(CompraDetalle::class);
    }
}
