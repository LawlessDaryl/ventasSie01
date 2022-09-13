<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','observacion','sucursal_id'];

    public function productos()
    {
        return $this->belongsToMany(Product::class,'productos_destinos','destino_id','id');
    }

 
    
    public function sucursals()
    {
        return $this->belongsTo(Sucursal::class,'sucursal_id','id');
    }
    public function dino()
    {
        return true;
    }


    public function ingresoproducto()
    {
        return $this->hasMany(IngresoProductos::class,'destino');
    }
    
    

}
