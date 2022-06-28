<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovPlan extends Model
{
    use HasFactory;

    protected $fillable = ['movimiento_id','plan_id'];

    public function Movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'movimiento_id', 'id');
    }
}
