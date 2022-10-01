<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepSolicitud extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','order_service_id','status'];

    public function detalle_solicitud()
    {
        return $this->hasMany(ServiceRepDetalleSolicitud::class,"solicitud_id");
    }
}
