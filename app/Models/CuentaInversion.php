<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaInversion extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'expiration_date', 'price', 'number_profiles', 'status', 'type', 'sale_profiles', 'imports', 'ganancia', 'account_id'];
}
