<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_prod','costo','caracteristicas','codigo','lote',
    'unidad','marca','garantia','cantidad_minima','industria','precio_venta',
                         'status','image', 'category_id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function location()
    {
        return $this->belongsToMany(Location::class,'productos_destinos');
    }


    public function getImagenAttribute()
    {
        if ($this->image == null)
        {
           return 'noimage.jpg';
        }
        if (file_exists('storage/productos/'. $this->image))
            return $this->image;
        else 
        {
            return 'noimage.jpg';
        }
    }


}
