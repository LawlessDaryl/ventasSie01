<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento_Compra extends Model
{
    use HasFactory;
    protected $fillable=['compra_id',
                         'movimiento_id'];
}
