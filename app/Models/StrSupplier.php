<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrSupplier extends Model
{
    use HasFactory;

    protected $fillable = ['name',
                        'phone',
                        'mail',
                        'address',
                        'status',
                        'image'
    ];

    public function cuentas()
    {
        return $this->hasMany(Account::class);
    }

    public function getImagenAttribute()
    {
        if ($this->image == null) {
            return 'noimage.jpg';
        }
        if (file_exists('storage/proveedores/' . $this->image))
            return $this->image;
        else {
            return 'noimage.jpg';
        }
    }
}
