<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepSolicitud extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','service_id','status'];
}
