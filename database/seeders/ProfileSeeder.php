<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'nameprofile' => 'netflixDividida1',
            'pin' => 'ntd1',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'netflixDividida2',
            'pin' => 'ntd2',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'netflixDividida3',
            'pin' => 'ntd3',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'netflixDividida4',
            'pin' => 'ntd3',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);

        Profile::create([
            'nameprofile' => 'disneyDividida1',
            'pin' => 'disd1',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'disneyDividida2',
            'pin' => 'disd2',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'disneyDividida3',
            'pin' => 'disd3',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);

        Profile::create([
            'nameprofile' => 'primeDiv1',
            'pin' => 'prid1',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'primeDiv2',
            'pin' => 'prid2',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'primeDiv3',
            'pin' => 'prid3',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);

        Profile::create([
            'nameprofile' => 'starDiv1',
            'pin' => 'stard1',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'starDiv2',
            'pin' => 'stard2',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'starDiv3',
            'pin' => 'stard3',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);

        Profile::create([
            'nameprofile' => 'hboDivi1',
            'pin' => 'hbod1',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'hboDivi2',
            'pin' => 'hbod2',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
        Profile::create([
            'nameprofile' => 'hboDivi3',
            'pin' => 'hbod3',
            'status' => 'ACTIVO',
            'availability' => 'LIBRE',
            'observations' => 'Ninguna',
        ]);
    }
}
