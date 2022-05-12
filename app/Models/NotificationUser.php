<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<<< HEAD:app/Models/DetalleDevolucion.php
class DetalleDevolucion extends Model
========
class NotificationUser extends Model
>>>>>>>> origin/pruebaschio:app/Models/NotificationUser.php
{
    use HasFactory;
    protected $fillable = ['user_id','notification_id'];
}
