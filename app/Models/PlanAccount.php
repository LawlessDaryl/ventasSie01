<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAccount extends Model
{
    use HasFactory;

    protected $fillable = ['status','plan_id', 'account_id'];

    public function Plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
