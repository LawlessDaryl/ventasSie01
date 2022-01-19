<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenMotivo extends Model
{
    use HasFactory;

    protected $fillable = ['origen_id','motivo_id'];
}
