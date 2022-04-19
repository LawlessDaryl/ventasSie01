<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transferencia_detalle extends Model
{
    use HasFactory;

    protected $fillable = ['transferencia_id','detalle_id'];
}
