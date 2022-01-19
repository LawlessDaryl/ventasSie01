<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name','adress','phone','nit_id'];

    public function relacionados()
    {
        return $this->hasMany(Sucursal::class);
    }
    
}
