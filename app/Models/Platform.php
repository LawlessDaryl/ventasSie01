<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public function getImagenAttribute()
    {
        if ($this->image == null) {
            return 'noimage.jpg';
        }
        if (file_exists('storage/plataformas/' . $this->image))
            return $this->image;
        else {
            return 'noimage.jpg';
        }
    }

}
