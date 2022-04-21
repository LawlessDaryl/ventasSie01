<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTrans_Detalle extends Model
{
    use HasFactory;
    protected $fillable= ['estado_id','detalle_id'];
}
