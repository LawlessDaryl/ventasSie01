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
            'status' => 'SinAsignar',
            'account_id' => '1',
            'profile_id' => '1',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil netflix */
            'status' => 'SinAsignar',
            'account_id' => '1',
            'profile_id' => '2',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil netflix */
            'status' => 'SinAsignar',
            'account_id' => '1',
            'profile_id' => '3',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil netflix */
            'status' => 'SinAsignar',
            'account_id' => '1',
            'profile_id' => '4',
            'plan_id' => null,
        ]);


        AccountProfile::create([   /* Perfil disney */
            'status' => 'SinAsignar',
            'account_id' => '2',
            'profile_id' => '5',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil disney */
            'status' => 'SinAsignar',
            'account_id' => '2',
            'profile_id' => '6',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil disney */
            'status' => 'SinAsignar',
            'account_id' => '2',
            'profile_id' => '7',
            'plan_id' => null,
        ]);


        AccountProfile::create([   /* Perfil prime */
            'status' => 'SinAsignar',
            'account_id' => '3',
            'profile_id' => '8',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil prime */
            'status' => 'SinAsignar',
            'account_id' => '3',
            'profile_id' => '9',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil prime */
            'status' => 'SinAsignar',
            'account_id' => '3',
            'profile_id' => '10',
            'plan_id' => null,
        ]);


        AccountProfile::create([   /* Perfil star */
            'status' => 'SinAsignar',
            'account_id' => '4',
            'profile_id' => '11',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil star */
            'status' => 'SinAsignar',
            'account_id' => '4',
            'profile_id' => '12',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil star */
            'status' => 'SinAsignar',
            'account_id' => '4',
            'profile_id' => '13',
            'plan_id' => null,
        ]);


        AccountProfile::create([   /* Perfil hbo */
            'status' => 'SinAsignar',
            'account_id' => '5',
            'profile_id' => '14',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil hbo */
            'status' => 'SinAsignar',
            'account_id' => '5',
            'profile_id' => '15',
            'plan_id' => null,
        ]);
        AccountProfile::create([   /* Perfil hbo */
            'status' => 'SinAsignar',
            'account_id' => '5',
            'profile_id' => '16',
            'plan_id' => null,
        ]);
        
    }
}
