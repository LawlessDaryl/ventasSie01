<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable=['importe_total','fecha_compra','impuestos','pago','saldo_por_pagar','tipo_doc','nro_documento','observacion','proveedor_id'];
    
    public function compradetalle()
    {
        return $this->hasMany(CompraDetalle::class);
    }
}
