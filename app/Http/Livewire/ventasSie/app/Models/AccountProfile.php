<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountProfile extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'COMBO', 'account_id', 'profile_id', 'plan_id'];

    public function Cuenta()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
    public function Perfil()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }
}
