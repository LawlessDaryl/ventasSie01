<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountProfile;
use Illuminate\Database\Seeder;

class AccountProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountProfile::create([   /* Perfil netflix */
            'status' => 'ACTIVO',
            'account_id' => '1',
            'profile_id' => '1',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil netflix */
            'status' => 'ACTIVO',
            'account_id' => '1',
            'profile_id' => '2',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil netflix */
            'status' => 'ACTIVO',
            'account_id' => '1',
            'profile_id' => '3',
            'plan_account_id' => null,
        ]);


        AccountProfile::create([   /* Perfil disney */
            'status' => 'ACTIVO',
            'account_id' => '2',
            'profile_id' => '4',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil disney */
            'status' => 'ACTIVO',
            'account_id' => '2',
            'profile_id' => '5',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil disney */
            'status' => 'ACTIVO',
            'account_id' => '2',
            'profile_id' => '6',
            'plan_account_id' => null,
        ]);


        AccountProfile::create([   /* Perfil prime */
            'status' => 'ACTIVO',
            'account_id' => '3',
            'profile_id' => '7',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil prime */
            'status' => 'ACTIVO',
            'account_id' => '3',
            'profile_id' => '8',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil prime */
            'status' => 'ACTIVO',
            'account_id' => '3',
            'profile_id' => '9',
            'plan_account_id' => null,
        ]);


        AccountProfile::create([   /* Perfil star */
            'status' => 'ACTIVO',
            'account_id' => '4',
            'profile_id' => '10',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil star */
            'status' => 'ACTIVO',
            'account_id' => '4',
            'profile_id' => '11',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil star */
            'status' => 'ACTIVO',
            'account_id' => '4',
            'profile_id' => '12',
            'plan_account_id' => null,
        ]);


        AccountProfile::create([   /* Perfil hbo */
            'status' => 'ACTIVO',
            'account_id' => '5',
            'profile_id' => '13',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil hbo */
            'status' => 'ACTIVO',
            'account_id' => '5',
            'profile_id' => '14',
            'plan_account_id' => null,
        ]);
        AccountProfile::create([   /* Perfil hbo */
            'status' => 'ACTIVO',
            'account_id' => '5',
            'profile_id' => '15',
            'plan_account_id' => null,
        ]);
        
    }
}
