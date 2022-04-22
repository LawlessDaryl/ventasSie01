<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Devolution extends Model
{
    use HasFactory;
    protected $fillable = ['id_devolutions', 'product_id', 'cantidad_dev', 'monto_dev', 'product_id2', 'cantidad_dev2'];
}
