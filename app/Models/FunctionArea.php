<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionArea extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'area_trabajo_id'];

    public function area(){
        return $this->belongsTo(AreaTrabajo::class);
    }
}
