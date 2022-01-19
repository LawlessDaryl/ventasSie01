<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','tipo','monto_a','monto_inicial','monto_final','comision','porcentaje'];

    public function relacionados()
    {
        return $this->hasMany(OrigenMotivoComision::class);
    }
}
