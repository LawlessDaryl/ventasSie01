<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = ['type','status','saldo','on_account','import','user_id'];

    public function climov()
    {
        return $this->hasOne(ClienteMov::class);
    }

    public function usermov()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function cartmov()
    {
        return $this->hasMany(CarteraMov::class);
    }
}
