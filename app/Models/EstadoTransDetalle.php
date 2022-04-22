<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTransDetalle extends Model
{
    use HasFactory;
    protected $fillable= ['estado_id','detalle_id'];
}
