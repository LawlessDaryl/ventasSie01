<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    use HasFactory;
    protected $fillable = ['precio','cantidad','product_id','sale_id','prod_dest_id'];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}


