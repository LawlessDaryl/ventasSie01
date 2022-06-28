<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $fillable = ['nombre','cedula','celular','telefono','direccion','email','fecha_nacim','razon_social','nit','procedencia_cliente_id'];
}
