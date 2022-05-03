<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nombre','costo','caracteristicas','codigo','lote',
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

    public function destino()
    {
        return $this->hasMany(ProductosDestino::class);
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
