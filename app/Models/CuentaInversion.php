<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaInversion extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'cantidad', 'tipoPlan', 'tipoTransac', 'num_meses', 'fecha_realizacion', 'account_id'];
}
