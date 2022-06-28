<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProdService extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','estado'];

    public function servicios()
    {
        return $this->hasMany(Service::class,'cat_prod_service_id','id');
    }
    public function subcat()
    {
        return $this->hasMany(SubCatProdService::class);
    }
}
