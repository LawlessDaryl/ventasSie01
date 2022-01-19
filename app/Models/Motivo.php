<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_motivo','tipo'];

    public function relacionados()
    {
        return $this->hasMany(OrigenMotivo::class);
    }

}
