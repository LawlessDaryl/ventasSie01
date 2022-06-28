<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCatProdService extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','status','cat_prod_service_id'];
}
