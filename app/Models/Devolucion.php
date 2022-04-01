<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $fillable = ['fecha_devolucion',
    'tipo',
    'tipo_dev',
    'sales_id',
    'compras_id',
    'observations'];
}
