<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estado', 'sucursal_id'];

    public function carteras()
    {
        return $this->hasMany(Cartera::class);
    }
}
