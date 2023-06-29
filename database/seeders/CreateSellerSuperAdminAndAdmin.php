<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;


use App\Models\User;


class CreateSellerSuperAdminAndAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'firstName' => 'Jorge David', //SuperAdmin
                'lastName'  => 'Galvis Tamara',
                'photo'     =>  null,
                'cellphone' => '3225687425',
                'email'     => 'jorge@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005478121',
                'password'  =>  Hash::make('1005478121'),
                'surveyId'  =>  null
            ],
            [
                'firstName' => 'Francisco Manuel', //Admin
                'lastName'  => 'Macea Arrieta',
                'photo'     =>  null,
                'cellphone' => '3225687426',
                'email'     => 'francisco@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005478122',
                'password'  =>  Hash::make('1005478122'),
                'surveyId'  =>  null
            ],
            [
                'firstName' => 'Maira', //Seller //Kaled
                'lastName'  => 'Gómez',
                'photo'     =>  null,
                'cellphone' => '3225687425',
                'email'     => 'maira@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005478123',
                'password'  =>  Hash::make('1005478123'),
                'surveyId'  =>  null
            ],
            [
                'firstName' => 'Hector', //Seller //Jose
                'lastName'  => 'Corcho',
                'photo'     =>  null,
                'cellphone' => '3181548725',
                'email'     => 'hector@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005472347',
                'password'  =>  Hash::make('1005472347'),
                'surveyId'  =>  null
            ],
            [
                'firstName' => 'Verónica', //Seller //Kaled
                'lastName'  => 'Cordero',
                'photo'     =>  null,
                'cellphone' => '3186512431',
                'email'     => 'veronica@gmail.com',
                'dniType'   => 'CC',
                'dni'       => '1005479536',
                'password'  =>  Hash::make('1005479536'),
                'surveyId'  =>  null
            ],

        ];

        foreach($users as $user) {
            if ( !User::query()->where('dni', $user['dni'])->first() ) {

                if ( strcmp($user['dni'], '1005478121')  === 0 ) {
                    $role = Role::query()->where('name', 'SuperAdmin')->first();
                    $permissions = Permission::query()
                        ->pluck('name', 'id')
                        ->all();
                }else if(strcmp($user['dni'], '1005478122')  === 0) {
                    $role = Role::query()->where('name', 'Admin')->first();
                    $permissions = Permission::query()
                        ->where('name', 'not like', 'role%')
                        ->pluck('name', 'id')
                        ->all();
                }else{
                    $role = Role::query()->where('name', 'Seller')->first();
                    $permissions = Permission::query()
                        ->where('name', 'like', 'visit%')
                        ->pluck('name', 'id')
                        ->all();
                }

                $role->syncPermissions($permissions);

                $response = new User();
                $response->firstName = $user['firstName'];
                $response->lastName  = $user['lastName'];
                $response->photo     = $user['photo'];
                $response->cellphone = $user['cellphone'];
                $response->email     = $user['email'];
                $response->dniType   = $user['dniType'];
                $response->dni       = $user['dni'];
                $response->password  = $user['password'];
                $response->surveyId  = $user['surveyId'];
                $response->assignRole($role);
                $response->save();
            }
        }
    }
}
