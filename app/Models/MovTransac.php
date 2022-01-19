<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovTransac extends Model
{
    use HasFactory;

    protected $fillable = ['movimiento_id','transaccion_id'];
}
