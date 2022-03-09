<?php

namespace Database\Seeders;

use App\Models\TypeWork;
use Illuminate\Database\Seeder;

class TypeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeWork::create([
            'name' => 'Mantenimiento',
            'status' => 'Active',
        ]);
        TypeWork::create([
            'name' => 'Reparación',
            'status' => 'Active',
        ]);
        TypeWork::create([
            'name' => 'Revisión',
            'status' => 'Active',
        ]);
    }
}
