<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    
    protected $fillable = ['codigo','descripcion','tipo','destino_id'];

    public function product(){
        return $this->belongsToMany(Product::class,'productos_destinos');
    }
}
