<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOperacion extends Model
{
    use HasFactory;
    
    protected $fillable= ['product_id','cantidad','id_operacion'];
}
