<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Platform::create([
            'nombre' => 'Netflix',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'SI',
            'image' => null,
            'precioEntera' => '95',
            'precioPerfil' => '25',
        ]);
        Platform::create([
            'nombre' => 'Disney Plus',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'SI',
            'image' => null,
            'precioEntera' => '40',
            'precioPerfil' => '20',
        ]);
        Platform::create([
            'nombre' => 'Prime Video',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'SI',
            'image' => null,
            'precioEntera' => '40',
            'precioPerfil' => '20',
        ]);
        Platform::create([
            'nombre' => 'Star Plus +',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'SI',
            'image' => null,
            'precioEntera' => '40',
            'precioPerfil' => '20',
        ]);
        Platform::create([
            'nombre' => 'HBO MAX',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'SI',
            'image' => null,
            'precioEntera' => '40',
            'precioPerfil' => '20',
        ]);
        Platform::create([
            'nombre' => 'Magis TV',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'USUARIO',
            'perfiles' => 'NO',
            'image' => null,
            'precioEntera' => '60',
            'precioPerfil' => '60',
        ]);
        Platform::create([
            'nombre' => 'Spotify',
            'descripcion' => 'Plataforma de música',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'NO',
            'image' => null,
            'precioEntera' => '20',
            'precioPerfil' => '20',
        ]);
        Platform::create([
            'nombre' => 'Youtube Premiun',
            'descripcion' => 'Plataforma de entretenimiento',
            'estado' => 'Activo',
            'tipo' => 'CORREO',
            'perfiles' => 'NO',
            'image' => null,
            'precioEntera' => '20',
            'precioPerfil' => '20',
        ]);
    }
}
