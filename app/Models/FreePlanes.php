<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreePlanes extends Model
{
    use HasFactory;
    protected $fillable= ['nameplan','nameoffer','cryptocurrencies','cost'];
}
