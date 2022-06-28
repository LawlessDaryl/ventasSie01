<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transference extends Model
{
    use HasFactory;
    protected $fillable=['observacion','estado','id_destino','id_origen'];
}
