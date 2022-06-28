<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;

    protected $fillable = ['codigo_transf', 'importe', 'observaciones', 'estado', 'telefono', 'ganancia', 'origen_motivo_id'];

    public function movTransac()
    {
        return $this->hasMany(MovTransac::class);
    }
}
