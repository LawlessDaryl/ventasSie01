<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sucursal_id', 'estado', 'fecha_fin'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class,'sucursal_id','id');
    }

}
