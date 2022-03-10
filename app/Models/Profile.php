<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['nameprofile', 'pin', 'status', 'availability', 'observations'];

    public function CuentaPerfil()
    {
        return $this->hasOne(AccountProfile::class, 'profile_id', 'id');
    }
}