<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountProfile extends Model
{
    use HasFactory;

    protected $fillable = ['status','account_id', 'profile_id', 'plan_account_id'];

    public function Cuenta()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
