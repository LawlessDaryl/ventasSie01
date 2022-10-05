<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areaspermissions extends Model
{
    use HasFactory;
    //meodos para añadir informacion para un llenador masivo
    protected $fillable = ['name'];
    //relacion que tiene con categoria 
    public function permisos()
    {
        return $this->hasMany(Permission::class);

    }
}
