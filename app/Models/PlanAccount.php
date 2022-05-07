<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAccount extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'COMBO', 'plan_id', 'account_id'];

    public function Plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
    public function Cuenta()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
