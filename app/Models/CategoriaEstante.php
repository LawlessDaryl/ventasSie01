<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaEstante extends Model
{
    use HasFactory;
    protected $fillable=['product_id','location_id'];
}
