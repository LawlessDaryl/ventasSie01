<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeSale extends Model
{
    use HasFactory;
    protected $fillable= ['nameclient','phone','idaccount','alias','observation','freeplanes_id','sucursals_id','user_id','movimiento_id','cartera_id'];
}
