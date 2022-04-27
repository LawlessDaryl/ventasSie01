<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevolutionSale extends Model
{
    use HasFactory;
    protected $fillable = ['tipo_dev','monto_dev','observations','product_id'];
}
