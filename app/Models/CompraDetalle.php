<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompraDetalle extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['precio','cantidad','product_id','compra_id'];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
    public function productos()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    
}


