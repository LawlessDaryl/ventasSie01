<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;
    protected $fillable = ['precio','cantidad','product_id','compra_id','destino_id'];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
    
}


