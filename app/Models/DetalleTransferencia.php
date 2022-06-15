<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTransferencia extends Model
{
    use HasFactory;
    protected $fillable= ['product_id','cantidad','estado'];
    
    public function producto()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}

