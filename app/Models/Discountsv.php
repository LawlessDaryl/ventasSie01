<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discountsv extends Model
{
    use HasFactory;
    protected $fillable = ['ci', 'descuento', 'motivo', 'fecha'];
}
