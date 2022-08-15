<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEntradaProductos extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','cantidad','costo','id_entrada','lote_id'];

    public function ingresoproductos()
    {
        return $this->belongsTo(IngresoProductos::class,'id_entrada','id');
    }
}
