<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenMotivo extends Model
{
    use HasFactory;

    protected $fillable = ['comision_si_no','afectadoSi','afectadoNo','suma_resta_si','suma_resta_no','CIdeCliente','telefSolicitante','telefDestino_codigo','origen_id','motivo_id'];

    public function relaciontr()
    {
        return $this->hasMany(Transaccion::class);
    }

    public function relacionados()
    {
        return $this->hasMany(OrigenMotivoComision::class);
    }
}
