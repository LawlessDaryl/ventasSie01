<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenMotivoComision extends Model
{
    use HasFactory;

    protected $fillable = ['origen_motivo_id', 'comision_id'];

    public function relacionados()
    {
        return $this->hasMany(OrigenMotivoComision::class);
    }
}
