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

    public function destinos()
    {
        return $this->belongsTo(Destino::class,'destino','id');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
