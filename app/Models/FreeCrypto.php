<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeCrypto extends Model
{
    use HasFactory;
    protected $fillable= ['cantidad'];
}
