<?php

namespace Database\Seeders;

use App\Models\Destino;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ss=Destino::create([
            'nombre'=>'Deposito',
            'observacion'=>'ninguna',
            'sucursal_id'=>'1'           
        ]);

        Permission::create([
            'name' => $ss->nombre.'_'.$ss->id,
            'guard_name' => 'web'
        ]);

       
        
        $dd=Destino::create([
            'nombre'=>'Tienda',
            'observacion'=>'ninguna',
            'sucursal_id'=>'1'           
        ]);
        Permission::create([
            'name' => $dd->nombre.'_'.$dd->id,
            'guard_name' => 'web'
        ]);

        $pg=Destino::create([
            'nombre'=>'Almacen Devoluciones',
            'observacion'=>'ninguna',
            'sucursal_id'=>'1'           
        ]);
        Permission::create([
            'name' => $pg->nombre.'_'.$pg->id,
            'guard_name' => 'web'
        ]);
        $mm= Destino::create([
            'nombre'=>'Tienda',
            'observacion'=>'ninguna',
            'sucursal_id'=>'2'           
        ]);
        Permission::create([
            'name' => $mm->nombre.'_'.$mm->id,
            'guard_name' => 'web'
        ]);

        $nn=Destino::create([
            'nombre'=>'Almacen',
            'observacion'=>'ninguna',
            'sucursal_id'=>'2'
        ]);
        Permission::create([
            'name' => $nn->nombre.'_'.$nn->id,
            'guard_name' => 'web'
        ]);

        $ff= Destino::create([
            'nombre'=>'Almacen Devoluciones',
            'observacion'=>'ninguna',
            'sucursal_id'=>'2'           
        ]);

        Permission::create([
            'name' => $ff->nombre.'_'.$ff->id,
            'guard_name' => 'web'
        ]);

    }
}
