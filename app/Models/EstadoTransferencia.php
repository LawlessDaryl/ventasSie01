<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTransferencia extends Model
{
    use HasFactory;
    protected $fillable= ['estado','id_transferencia','id_usuario'];
}
