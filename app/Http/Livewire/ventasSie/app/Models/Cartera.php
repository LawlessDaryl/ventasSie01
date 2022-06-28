<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartera extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'tipo', 'telefonoNum', 'caja_id'];

    public function carteraMovimientos()
    {
        return $this->hasMany(CarteraMov::class);
    }
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
