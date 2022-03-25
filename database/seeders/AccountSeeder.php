<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([   /* cuenta netflix dividida */
            'start_account' => '2022-03-22',
            'expiration_account' => '2022-04-22',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '4',
            'password_account' => 'netflixd1',
            'price' => '90',
            'availability' => 'LIBRE',
            'str_supplier_id' => '1',
            'platform_id' => '1',
            'email_id' => '1',
        ]);
        Account::create([   /* cuenta disney dividida */
            'start_account' => '2022-03-15',
            'expiration_account' => '2022-04-15',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '6',
            'password_account' => 'disneyd1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '1',
            'platform_id' => '2',
            'email_id' => '2',
        ]);
        Account::create([   /* cuenta prime video dividida */
            'start_account' => '2022-03-11',
            'expiration_account' => '2022-04-11',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '4',
            'password_account' => 'primed1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '3',
            'email_id' => '3',
        ]);
        Account::create([   /* cuenta star plus dividida */
            'start_account' => '2022-03-02',
            'expiration_account' => '2022-04-02',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '6',
            'password_account' => 'stard1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '4',
            'email_id' => '4',
        ]);
        Account::create([   /* cuenta HBO MAX dividida */
            'start_account' => '2022-03-01',
            'expiration_account' => '2022-04-01',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '4',
            'password_account' => 'hbod1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '5',
            'email_id' => '5',
        ]);
        Account::create([   /* Cuenta magis tv */
            'start_account' => '2022-03-25',
            'expiration_account' => '2022-04-25',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '1',
            'password_account' => 'magis1',
            'price' => '55',
            'availability' => 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '6',
            'email_id' => '6',
        ]);
        Account::create([   /* CUENTA DE NETFLIX ENTERA */
            'start_account' => '2022-03-25',
            'expiration_account' => '2022-04-25',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '4',
            'password_account' => 'netflix1',
            'price' => '90',
            'availability' => 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '1',
            'email_id' => '7',
        ]);
        Account::create([   /* CUENTA DE DISNEY ENTERA */
            'start_account' => '2022-03-25',
            'expiration_account' => '2022-04-25',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '6',
            'password_account' => 'disney1',
            'price' => '35',
            'availability' => 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '2',
            'email_id' => '8',
        ]);
    }
}
