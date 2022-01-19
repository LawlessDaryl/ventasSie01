<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;

    protected $fillable = ['codigo_transf', 'importe', 'utilidad', 'costo', 'observaciones', 'fecha_transaccion','estado','telefono', 'origen_motivo_id'];
}
