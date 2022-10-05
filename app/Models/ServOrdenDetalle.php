<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServOrdenDetalle extends Model
{
    use HasFactory;
    protected $fillable = ['detalle_solicitud_id','product_id','cantidad','status'];
}
