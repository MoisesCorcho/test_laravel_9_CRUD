<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {

        $permissions = [
            /* Permiso para modulo de Roles */
            'role-list',
            'role-view',
            'role-create',
            'role-edit',
            'role-delete',
            /* Permiso para modulo de Usuarios */
            'user-list',
            'user-view',
            'user-create',
            'user-edit',
            'user-delete',
            /* Permisos para modulo de Clientes */
            'client-list',
            'client-view',
            'client-create',
            'client-edit',
            'client-delete',
            /* Permisos para modulo de Clientes */
            'visit-list',
            'visit-view',
            'visit-create',
            'visit-edit',
            'visit-delete',
        ];

        foreach ($permissions as $permission){
            $per = Permission::query()->where('name', $permission)->first();
            if(!$per) Permission::create(['guard_name' => 'api', 'name' => $permission]);
        }

    }
}
