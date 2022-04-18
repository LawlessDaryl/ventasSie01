<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transference extends Model
{
    use HasFactory;
    protected $fillable=['fecha_transferencia','status','id_usuario'];
}
