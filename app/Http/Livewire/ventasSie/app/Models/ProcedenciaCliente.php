<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedenciaCliente extends Model
{
    use HasFactory;

    protected $fillable = ['procedencia', 'estado'];
    
    public function relacionados()
    {
        return $this->hasMany(Cliente::class);
    }
}
