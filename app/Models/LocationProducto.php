<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationProducto extends Model
{
    use HasFactory;
    protected $fillable =  ['product','location'];

    
    public function producto()
    {
        return $this->belongsTo(Product::class,'product','id');
    }
    public function locations()
    {
        return $this->belongsTo(Location::class,'location','id');
    }
}

