<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleLote extends Model
{
    use HasFactory;
    
    protected $fillable = ['sale_detail_id', 'lote_id', 'cantidad'];
}
