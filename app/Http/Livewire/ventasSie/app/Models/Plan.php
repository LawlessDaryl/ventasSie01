<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['importe', 'plan_start', 'expiration_plan', 'meses', 'ready', 'done', 'type_plan', 'status', 'type', 'type_pay', 'observations', 'comprobante', 'movimiento_id'];

    public function Mov()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id', 'id');
    }
    public function PlanAccounts()
    {
        return $this->hasMany(PlanAccount::class);
    }
}
