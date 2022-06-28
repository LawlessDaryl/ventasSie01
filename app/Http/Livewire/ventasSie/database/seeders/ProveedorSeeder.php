<?php

namespace Database\Seeders;

use App\Models\StrSupplier;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StrSupplier::create([
            'name'=>'Propia',
            'phone'=>'',
            'mail'=>'',
            'address'=>'',
            'status'=>'ACTIVO',
            'image'=>null
        ]);
        StrSupplier::create([
            'name'=>'Kira Yoshikage',
            'phone'=>'76789809',
            'mail'=>'kiraqueen@gmail.com',
            'address'=>'Av. Libertador y America',
            'status'=>'ACTIVO',
            'image'=>null
        ]);
        StrSupplier::create([
            'name'=>'Yushiro Hanma',
            'phone'=>'72785509',
            'mail'=>'HanmaYushiro@gmail.com',
            'address'=>'Av. Ayacucho y Heroinas',
            'status'=>'ACTIVO',
            'image'=>null
        ]);
        StrSupplier::create([
            'name'=>'Okabe Rintaro',
            'phone'=>'66789809',
            'mail'=>'ZombiePsy@gmail.com',
            'address'=>'Av. Melchor Perez y America',
            'status'=>'ACTIVO',
            'image'=>null
        ]);
    }
}
