<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionUsuario extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','notificacion_id'];
}
