<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

    use HasFactory;
    protected $fillable = ['nombre', 'apellido','direccion',
    'telefono','Compañia','correo','status'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
