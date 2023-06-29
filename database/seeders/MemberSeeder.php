<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\Organization;
use App\Models\Member;
use App\Models\MemberPosition;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $members = [
            [
                'firstName' => 'Eugenio David',
                'lastName'  => 'Hernandez Hernandez',
                'dniType'   => 'CC',
                'dni'       => '1005478121',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3225687425',
                'birthday'  => Carbon::now(),
                'email'     => 'eugenio@gmail.com',
            ],
            [
                'firstName' => 'Daniel Eduardo',
                'lastName'  => 'Perez Doria',
                'dniType'   => 'CC',
                'dni'       => '1005478132',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3225687425',
                'birthday'  => Carbon::now(),
                'email'     => 'danieleduardo@gmail.com',
            ],
            [
                'firstName' => 'Daniel Enrique',
                'lastName'  => 'Guerra Mezquida',
                'dniType'   => 'CC',
                'dni'       => '1005478156',
                'address'   => 'Calle 35 No 14-49 / Barrio La Floresta',
                'cellphone' => '3225687425',
                'birthday'  => Carbon::now(),
                'email'     => 'danielenrique@gmail.com',
            ],
        ];

        $organization   = Organization::query()->where('nit', '1004731778')->first();
        $memberPosition = MemberPosition::query()->where('name', 'Gerente - Administrador')->first();

        foreach ($members as $member) {
            if (!Member::query()->where('dni', $member['dni'])->first()) {
                $response = new Member();
                $response->firstName = $member['firstName'];
                $response->lastName  = $member['lastName'];
                $response->dniType   = $member['dniType'];
                $response->dni       = $member['dni'];
                $response->address   = $member['address'];
                $response->birthday  = $member['birthday'];
                $response->email     = $member['email'];
                $response->organization()->associate($organization);
                $response->position()->associate($memberPosition);
                $response->save();
            }
        }
    }
}
