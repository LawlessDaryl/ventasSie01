<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaProductos extends Model
{
    use HasFactory;
    protected $fillable = ['destino','user_id','concepto','observacion'];

    public function detallesalida()
    {
        return $this->hasMany(DetalleSalidaProductos::class,'id_salida');
    }
}
