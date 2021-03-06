<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['detalle','falla_segun_cliente','diagnostico','solucion','costo','fecha_estimada_entrega','cliente_id','cat_prod_service_id','order_service_id','type_work_id'];
}
