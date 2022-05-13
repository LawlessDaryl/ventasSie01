<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosDestino extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable=['product_id','destino_id','stock'];
=======
    protected $fillable=['id','product_id','location_id','stock'];
>>>>>>> pruebaschio

    
    public function productos(){
       $this->belongsTo(Product::class);  
    }

   
}
