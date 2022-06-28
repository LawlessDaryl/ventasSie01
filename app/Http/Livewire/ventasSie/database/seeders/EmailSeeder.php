<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Email::create([ /* 1 */
            'content' => 'Sin Correo',
            'pass' => '',
            'availability' => 'LIBRE',
            'status' => 'ACTIVO',
            'observations' => 'Email para plataformas sin correo',
        ]);
        Email::create([     /* 2 */
            'content' => 'emanuelmkmxpm@gmail.com',
            'pass' => 'cicfzlemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 3 */
            'content' => 'emanuelbolaoq@gmail.com',
            'pass' => 'msgcghemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 4 */
            'content' => 'emanueluofsqh@gmail.com',
            'pass' => 'eqiirbemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 5 */
            'content' => 'emanuelrfcmml@gmail.com',
            'pass' => 'sewyryemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 6 */
            'content' => 'emanuelbwykeq@gmail.com',
            'pass' => 'lzziinemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 7 */
            'content' => 'emanuelqwertq@gmail.com',
            'pass' => 'lzziinemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 8 */
            'content' => 'emanuelqwer10@gmail.com',
            'pass' => 'lzziinemanuel',
            'availability' => 'OCUPADO',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 9 */
            'content' => 'emanuelqwer11@gmail.com',
            'pass' => 'lzziinemanuel',
            'availability' => 'LIBRE',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 10 */
            'content' => 'emanuelqwer12@gmail.com',
            'pass' => 'lzziinemanuel',
            'availability' => 'LIBRE',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
        Email::create([ /* 11 */
            'content' => 'emanuelqwer13@gmail.com',
            'pass' => 'lzziinemanuel',
            'availability' => 'LIBRE',
            'status' => 'ACTIVO',
            'observations' => 'Cuenta para la plataforma',
        ]);
    }
}
