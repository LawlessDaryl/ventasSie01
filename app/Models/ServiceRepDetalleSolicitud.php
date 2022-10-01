<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepDetalleSolicitud extends Model
{
    use HasFactory;
    protected $fillable = ['solicitud_id','product_id','service_id','destino_id','cantidad','tipo','status'];

    public function estado_solicitud()
    {
        return $this->hasMany(ServiceRepEstadoSolicitud::class,"detalle_solicitud_id");
    }
}
