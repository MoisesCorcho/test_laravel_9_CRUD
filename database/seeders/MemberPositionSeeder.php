<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MemberPosition;

class MemberPositionSeeder extends Seeder
{

    public function run()
    {
        $memberPositions = [
            [
                'name' => 'Gerente - Administrador',
                'description' => ''
            ],
            [
                'name' => 'Farmacia - Regente de Farmacia - Bodega - Almacén',
                'description' => ''
            ],
            [
                'name' => 'Compras',
                'description' => ''
            ],
            [
                'name' => 'Pagador - Financiero - Tesorería/Jurídica',
                'description' => ''
            ],
        ];

        foreach ($memberPositions as $memberPosition) {
            if (!MemberPosition::query()->where('name', $memberPosition['name'])->first()) {
                $response = new MemberPosition();
                $response->name        = $memberPosition['name'];
                $response->description = $memberPosition['description'];
                $response->save();
            }
        }
    }
}
