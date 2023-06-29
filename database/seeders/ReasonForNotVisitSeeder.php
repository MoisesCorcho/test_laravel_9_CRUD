<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonForNotVisitSeeder extends Seeder
{

    public function run()
    {
        $reasons = [
            [
                'id'   => \Str::uuid(),
                'name' => 'Cliente no disponible'
            ],
            [
                'id'   => \Str::uuid(),
                'name' => 'Cambio de ruta'
            ],
            [
                'id'   => \Str::uuid(),
                'name' => 'Trabajo desde la oficina'
            ],
        ];

        foreach($reasons as $reason){
            if(!DB::table('reasonForNotVisits')->where('id',$reason['id'])->first()){
                DB::table('reasonForNotVisits')->insert($reason);
            }
        }

    }
}
