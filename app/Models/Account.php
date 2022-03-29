<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['start_account', 'expiration_account', 'status', 'whole_account', 'number_profiles', 'password_account', 'price', 'availability', 'meses_comprados', 'str_supplier_id', 'platform_id', 'email_id'];

    public function CuentaPerfiles()
    {
        return $this->hasOne(AccountProfile::class);
    }

    public function PlanCuenta()
    {
        return $this->hasOne(PlanAccount::class);
    }

    public function Correo()
    {
        return $this->belongsTo(Email::class, 'email_id', 'id');
    }
    public function Proveedor()
    {
        return $this->belongsTo(StrSupplier::class, 'str_supplier_id', 'id');
    }
    public function Plataforma()
    {
        return $this->belongsTo(Platform::class, 'platform_id', 'id');
    }
}
