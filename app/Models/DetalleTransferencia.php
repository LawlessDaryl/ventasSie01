<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTransferencia extends Model
{
    use HasFactory;
    protected $fillable= ['id_transference','product_id','cantidad','id_destino'];
}
