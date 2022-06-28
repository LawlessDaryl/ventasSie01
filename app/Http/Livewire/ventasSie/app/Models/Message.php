<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'module_id', 'content', 'status'];

    public function notif()
    {
        return $this->hasMany(Notification::class);
    }
}
