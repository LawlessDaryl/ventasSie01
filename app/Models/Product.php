<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','costo','caracteristicas','codigo','barcode','lote',
    'unidad','marca','industria','precio_venta','cantidad_minima','stock',
                         'status','image', 'category_id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
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
