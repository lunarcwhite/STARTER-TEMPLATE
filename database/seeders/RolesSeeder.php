<?php

namespace Database\Seeders;
use App\Models\Role;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Admin',
            ],
            [
                'id' => 2,
                'name' => 'User',
            ]
        ];
            foreach ($roles as $key => $role){
                Role::create($role);
            }
    }
}
