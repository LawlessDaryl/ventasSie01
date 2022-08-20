<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSalidaProductos extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','cantidad','id_salida'];
  
    public function salidaproductos()
    {
        return $this->belongsTo(SalidaProductos::class,'id_salida','id');
    }

    public function productos(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
