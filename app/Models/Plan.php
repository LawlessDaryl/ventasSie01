<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['importe', 'expiration_plan', 'status', 'type', 'type_pay', 'observations'];

    public function MovPlan()
    {
        return $this->hasOne(MovPlan::class);
    }
}
