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
                            'destino_id',
                            'user_id',
                            'lote_compra'
                        ];
    
    public function compradetalle()
    {
        return $this->hasMany(CompraDetalle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function destino()
    {
        return $this->belongsTo(Destino::class,'destino_id','id');
    }

}
