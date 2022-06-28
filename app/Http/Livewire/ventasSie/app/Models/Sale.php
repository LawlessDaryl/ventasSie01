<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['total','items','cash','change','status','tipopago','factura','user_id','movimiento_id','cartera_id','observacion'];
}
