<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

    use HasFactory;
    protected $fillable = ['nombre_prov', 'apellido','direccion',
    'telefono','Compañia','correo','status'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getImagenAttribute()
    {
        if ($this->image == null) {
            return 'noimagen.png';
        }
        if (file_exists('storage/proveedores/' . $this->image))
            return $this->image;
        else {
            return 'noimagen.png';
        }
    }
}
