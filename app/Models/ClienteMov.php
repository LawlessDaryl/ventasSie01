<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteMov extends Model
{
    use HasFactory;

    protected $fillable = ['movimiento_id','cliente_id'];
    public function client()
    {
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }

}
