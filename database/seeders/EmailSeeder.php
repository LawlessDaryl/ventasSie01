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
        Email::create([
            'content'=> 'emanuelmkmxpm@gmail.com',
            'pass'=> 'cicfzlemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelbolaoq@gmail.com',
            'pass'=> 'msgcghemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanueluofsqh@gmail.com',
            'pass'=> 'eqiirbemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelrfcmml@gmail.com',
            'pass'=> 'sewyryemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelbwykeq@gmail.com',
            'pass'=> 'lzziinemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelqwertq@gmail.com',
            'pass'=> 'lzziinemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelqwer10@gmail.com',
            'pass'=> 'lzziinemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelqwer11@gmail.com',
            'pass'=> 'lzziinemanuel',
            'availability'=> 'OCUPADO',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelqwer12@gmail.com',
            'pass'=> 'lzziinemanuel',
            'availability'=> 'LIBRE',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
        Email::create([
            'content'=> 'emanuelqwer13@gmail.com',
            'pass'=> 'lzziinemanuel',
            'availability'=> 'LIBRE',
            'status'=> 'ACTIVO',
            'observations'=> 'Cuenta para la plataforma',
        ]);
    }
}
