<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([  /* usuario 1 */
            'name' => 'Emanuel',
            'phone' => '6187236',
            'email' => 'emanuel@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([  /* usuario 2 */
            'name' => 'Gustavo',
            'phone' => '6187236',
            'email' => 'gustavo@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([  /* usuario 3 */
            'name' => 'Armando',
            'phone' => '68007552',
            'email' => 'arramado@gmail.com',
            'profile' => 'CAJA_ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('armando1991')
        ]);
        User::create([  /* usuario 4 */
            'name' => 'Samuel',
            'phone' => '62702872',
            'email' => 'samuelcalebsuarezvaldivia@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([  /* usuario 5 */
            'name' => 'luis',
            'phone' => '78355246',
            'email' => 'offefa@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('lucho')
        ]);
        User::create([  /* usuario 6 */
            'name' => 'Pedro',
            'phone' => '77885544',
            'email' => 'pedro@gmail.com',
            'profile' => 'TECNICO',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([  /* usuario 7 */
            'name' => 'Andres',
            'phone' => '77448822',
            'email' => 'andres@gmail.com',
            'profile' => 'SUPERVISOR_TECNICO',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([  /* usuario 8 */
            'name' => 'Sergio',
            'phone' => '77331122',
            'email' => 'sergio@gmail.com',
            'profile' => 'CAJERO',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([  /* usuario 9 */
            'name' => 'caja1Central',
            'phone' => '',
            'email' => 'caja1@gmail.com',
            'profile' => 'CAJERO',
            'status' => 'ACTIVE',
            'password' => bcrypt('caja1')
        ]);
    }
}
