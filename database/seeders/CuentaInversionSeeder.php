<?php

namespace Database\Seeders;

use App\Models\CuentaInversion;
use Illuminate\Database\Seeder;

class CuentaInversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CuentaInversion::create([   /* cuenta netflix dividida */
            /* 'start_account' => '2022-03-22',
            'expiration_account' => '2022-04-22',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '4',
            'password_account' => 'netflixd1',
            'price' => '90',
            'availability' => 'LIBRE',
            'str_supplier_id' => '1',
            'platform_id' => '1',
            'email_id' => '1', */

            'start_date' => '2022-03-22',
            'expiration_date' => '2022-04-22',
            'price' => '90',
            'number_profiles' => '4',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => 1,
        ]);
        CuentaInversion::create([   /* cuenta disney dividida */
            /* 'start_account' => '2022-03-15',
            'expiration_account' => '2022-04-15',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '6',
            'password_account' => 'disneyd1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '1',
            'platform_id' => '2',
            'email_id' => '2', */

            'start_date' => '2022-03-15',
            'expiration_date' => '2022-04-15',
            'price' => '35',
            'number_profiles' => '6',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '2',
        ]);
        CuentaInversion::create([   /* cuenta prime video dividida */
            /* 'start_account' => '2022-03-11',
            'expiration_account' => '2022-04-11',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '4',
            'password_account' => 'primed1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '3',
            'email_id' => '3', */

            'start_date' => '2022-03-11',
            'expiration_date' => '2022-04-11',
            'price' => '35',
            'number_profiles' => '4',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '3',
        ]);
        CuentaInversion::create([   /* cuenta star plus dividida */
            /* 'start_account' => '2022-03-02',
            'expiration_account' => '2022-04-02',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '3',
            'password_account' => 'stard1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '4',
            'email_id' => '4', */

            'start_date' => '2022-03-02',
            'expiration_date' => '2022-04-02',
            'price' => '35',
            'number_profiles' => '3',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '4',
        ]);
        CuentaInversion::create([   /* cuenta HBO MAX dividida */
            /* 'start_account' => '2022-03-01',
            'expiration_account' => '2022-04-01',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '4',
            'password_account' => 'hbod1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '5',
            'email_id' => '5', */

            'start_date' => '2022-03-01',
            'expiration_date' => '2022-04-01',
            'price' => '35',
            'number_profiles' => '4',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '5',
        ]);
        CuentaInversion::create([   /* Cuenta magis tv */
            /* 'start_account' => '2022-03-25',
            'expiration_account' => '2022-04-25',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '1',
            'password_account' => 'magis1',
            'price' => '55',
            'availability' => 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '6',
            'email_id' => '6', */

            'start_date' => '2022-03-25',
            'expiration_date' => '2022-04-25',
            'price' => '55',
            'number_profiles' => '1',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '6',
        ]);
        CuentaInversion::create([   /* CUENTA DE NETFLIX ENTERA */
            /* 'start_account' => '2022-03-26',
            'expiration_account' => '2022-04-26',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '4',
            'password_account' => 'netflix1',
            'price' => '90',
            'availability' => 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '1',
            'email_id' => '7', */

            'start_date' => '2022-03-25',
            'expiration_date' => '2022-04-25',
            'price' => '90',
            'number_profiles' => '1',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '7',
        ]);
        CuentaInversion::create([   /* CUENTA DE DISNEY ENTERA */
            /* 'start_account' => '2022-03-26',
            'expiration_account' => '2022-04-26',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '3',
            'password_account' => 'disney1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '2',
            'email_id' => '8', */

            'start_date' => '2022-03-25',
            'expiration_date' => '2022-04-25',
            'price' => '35',
            'number_profiles' => '6',
            'sale_profiles' => 0,
            'imports' => 0,
            'ganancia' => 0,
            'account_id' => '8',
        ]);
    }
}
