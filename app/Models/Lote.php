<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = ['existencia','costo','status','product_id'];

    public function productos(){
        
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
