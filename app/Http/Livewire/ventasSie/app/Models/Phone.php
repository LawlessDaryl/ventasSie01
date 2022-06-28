<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'description', 'status', 'sucursal_id'];

    public function notif()
    {
        return $this->hasMany(Notification::class);
    }
}
