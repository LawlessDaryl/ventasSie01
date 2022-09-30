<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepEstadoSolicitud extends Model
{
    use HasFactory;
    protected $fillable = ['detalle_solicitud_id','user_id','status','estado'];
}
