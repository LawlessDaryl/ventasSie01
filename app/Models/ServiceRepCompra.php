<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepCompra extends Model
{
    use HasFactory;
    protected $fillable = ['compra_id','solicitud_id'];
}
