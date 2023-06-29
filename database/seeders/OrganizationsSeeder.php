<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Organization;

class OrganizationsSeeder extends Seeder
{
    public function run()
    {
        $organizations = [
            [
                'name'      => 'Droguerias la botica',
                'nit'       => '1004731778',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3165893612',
                'email'     => 'drogueriabotica@gmail.com',
                'city'      => 'Montería'
            ],
            [
                'name'      => 'Droguerias la rebaja',
                'nit'       => '1004731745',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3155893667',
                'email'     => 'drogueriarebaja@gmail.com',
                'city'      => 'Montería'
            ],
            [
                'name'      => 'Drogueria la Economia',
                'nit'       => '1004731734',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3165893698',
                'email'     => 'drogueriaeconomia@gmail.com',
                'city'      => 'Montería'
            ],
        ];

        $seller = User::query()->where('dni', '1005478123')->first();

        foreach ($organizations as $organization) {
            if (!Organization::query()->where('nit', $organization['nit'])->first()) {
                $response = new Organization();
                $response->name      = $organization['name'];
                $response->nit       = $organization['nit'];
                $response->address   = $organization['address'];
                $response->cellphone = $organization['cellphone'];
                $response->email     = $organization['email'];
                $response->city      = $organization['city'];
                $response->seller()->associate($seller);
                $response->save();
            }
        }

    }
}
