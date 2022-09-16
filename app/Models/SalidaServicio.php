<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaServicio extends Model
{
    use HasFactory;
    protected $fillable = ['salida_id','service_id','estado'];
}
