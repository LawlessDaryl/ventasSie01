<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenMotivoComision extends Model
{
    use HasFactory;

    protected $fillable = ['origen_motivos_id', 'comision_id', 'nombre'];
}
