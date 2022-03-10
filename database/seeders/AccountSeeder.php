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
            'expiration_account' => '2022-04-22 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '3',
            'password_account' => 'netflixd1',
            'price'=> '90',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '1',
            'platform_id' => '1',
            'email_id' => '1',
        ]);
        Account::create([   /* cuenta disney dividida */
            'expiration_account' => '2022-04-15 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '3',
            'password_account' => 'disneyd1',
            'price'=> '35',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '1',
            'platform_id' => '2',
            'email_id' => '2',
        ]);
        Account::create([   /* cuenta prime video dividida */
            'expiration_account' => '2022-04-11 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '3',
            'password_account' => 'primed1',
            'price'=> '35',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '3',
            'email_id' => '3',
        ]);
        Account::create([   /* cuenta star plus dividida */
            'expiration_account' => '2022-04-02 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '3',
            'password_account' => 'stard1',
            'price'=> '35',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '4',
            'email_id' => '4',
        ]);
        Account::create([   /* cuenta HBO MAX dividida */
            'expiration_account' => '2022-04-01 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'DIVIDIDA',
            'number_profiles' => '3',
            'password_account' => 'hbod1',
            'price'=> '35',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '2',
            'platform_id' => '5',
            'email_id' => '5',
        ]);
        Account::create([   /* Cuenta magis tv */
            'expiration_account' => '2022-04-25 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '1',
            'password_account' => 'magis1',
            'price'=> '55',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '6',
            'email_id' => '6',
        ]);
        Account::create([   /* CUENTA DE NETFLIX ENTERA */
            'expiration_account' => '2022-04-26 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '3',
            'password_account' => 'netflix1',
            'price'=> '90',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '1',
            'email_id' => '7',
        ]);
        Account::create([   /* CUENTA DE DISNEY ENTERA */
            'expiration_account' => '2022-04-26 14:17:47',
            'status' => 'ACTIVO',
            'whole_account' => 'ENTERA',
            'number_profiles' => '3',
            'password_account' => 'disney1',
            'price'=> '35',
            'availability'=> 'LIBRE',
            'str_supplier_id' => '3',
            'platform_id' => '2',
            'email_id' => '8',
        ]);
        
    }
}