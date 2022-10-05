<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{
    use HasFactory;
    protected $fillable = ['empleado_id', 'anticipo', 'motivo'];
}