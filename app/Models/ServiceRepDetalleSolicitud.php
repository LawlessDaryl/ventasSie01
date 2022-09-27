<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepDetalleSolicitud extends Model
{
    use HasFactory;
    protected $fillable = ['solicitud_id','product_id','cantidad','tipo','status'];
}
