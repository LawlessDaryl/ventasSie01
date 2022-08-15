<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoProductos extends Model
{
    use HasFactory;

    protected $fillable = ['destino','user_id','concepto','observacion'];

    
    public function detalleingreso()
    {
        return $this->hasMany(DetalleEntradaProductos::class,'id_entrada');
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
