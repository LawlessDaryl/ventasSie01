<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    
    protected $fillable = ['sucursal_id', 'codigo','descripcion','ubicacion','tipo'];

    public function product(){
        return $this->belongsToMany(Product::class,'productos_destinos');
    }
}
