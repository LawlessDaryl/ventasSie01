<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getImagenAttribute()
    {
        if ($this->image == null) {
            return 'noimage.jpg';
        }
        if (file_exists('storage/categorias/' . $this->image))
            return $this->image;
        else {
            return 'noimage.jpg';
        }
    }
}
