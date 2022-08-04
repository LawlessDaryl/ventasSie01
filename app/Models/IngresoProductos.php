<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoProductos extends Model
{
    use HasFactory;

    protected $fillable = ['destino','user_id','concepto','observacion'];
}
