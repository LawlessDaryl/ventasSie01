<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteraMov extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'tipoDeMovimiento', 'comentario', 'cartera_id', 'movimiento_id'];

        public function cartera()
    {
        return $this->belongsTo(Cartera::class);
    }

}
