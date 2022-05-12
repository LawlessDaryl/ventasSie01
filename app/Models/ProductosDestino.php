<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosDestino extends Model
{
    use HasFactory;

    protected $fillable=['product_id','destino_id','stock'];

    
    public function productos(){
       $this->belongsTo(Product::class);  
    }

   
}
