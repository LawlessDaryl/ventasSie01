<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = ['name','adress','telefono','celular','nit_id','company_id'];
    
    public function destino()
    {
        return $this->hasMany(Destino::class,'sucursal_id','id');
    }
}
