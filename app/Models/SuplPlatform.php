<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuplPlatform extends Model
{
    use HasFactory;

    protected $fillable = ['platform_id','supplier_id'];

    public function platforms()
    {
        return $this->hasMany(ProvPlatform::class);
    }
}
