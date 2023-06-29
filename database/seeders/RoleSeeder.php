<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SuperAdmin',
            'Admin',
            'Seller'
        ];

        foreach ($roles as $role) {
            if (!Role::query()->where('name', $role)->first()) {
                Role::create(['name' => $role, 'guard_name' => 'api']);
            }
        }
    }
}
