<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepMensajero extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','estado_solicitud_id','tiempoestimado'];
}
