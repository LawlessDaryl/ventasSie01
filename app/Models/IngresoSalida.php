<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoSalida extends Model
{
    use HasFactory;
    
    protected $fillable= ['proceso','destino','user_id','concepto','observacion'];
    
}

