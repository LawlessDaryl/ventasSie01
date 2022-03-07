<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosDestino extends Model
{
    use HasFactory;

    protected $fillable=['product-id','destino-id','stock'];

    public function productos(){
       $this->hasOne(Product::class);  
    }
    public function locations(){
       $this->hasOne(Location::class);  
    }
}
