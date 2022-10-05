<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaTrabajo extends Model
{
    use HasFactory;
    protected $fillable = ['nameArea', 'descriptionArea'];

    public function employee(){
        return $this->hasMany(Employee::class);
    }

    public function functionArea(){
        return $this->hasMany(FunctionArea::class);
    }
}
