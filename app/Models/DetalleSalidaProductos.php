<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSalidaProductos extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','cantidad','id_entrada','lote_id'];
  
    public function salidaproductos()
    {
        return $this->belongsTo(SalidaProductos::class,'id_salida','id');
    }
}
