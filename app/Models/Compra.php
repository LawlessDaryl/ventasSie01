<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['importe_total',
                            'descuento',
                            'fecha_compra',
                            'transaccion',
                            'saldo',
                            'tipo_doc',
                            'nro_documento',
                            'observacion',
                            'proveedor_id',
                            'estado_compra',
                            'status',
<<<<<<< HEAD
                            'destino_id'
=======
                            'destino_id',
                            'user_id'
>>>>>>> 7de76cfeff1f7fa3b8234322b59ba950625b7c77
                        ];
    
    public function compradetalle()
    {
        return $this->hasMany(CompraDetalle::class);
    }
}
