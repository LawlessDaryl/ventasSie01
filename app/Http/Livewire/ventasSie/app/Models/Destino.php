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
        return $this->belongsToMany(Product::class,'productos_destinos','product_id','destino_id');
    }
    
    public function sucursals()
    {
        return $this->belongsTo(Sucursal::class,'sucursal_id','id');
    }
    public function dino()
    {
        return true;
    }
    

}
