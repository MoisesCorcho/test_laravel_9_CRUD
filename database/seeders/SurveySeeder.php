<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Survey;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $surveys = [
            [
                'title'       => 'Surtimed - clientes',
                'description' => 'Encuesta a completar durante las visitas con clientes.',
                'status'      => 1,
            ],
        ];

        $owner  = User::where('dni', '1005478122')->first();

        foreach ($surveys as $survey) {
            if (!Survey::where('title', $survey['title'])->first()) {
                $response = new Survey();
                $response->title       = $survey['title'];
                $response->description = $survey['description'];
                $response->status      = $survey['status'];
                // Poner las llaves foraneas de seller y creador
                $response->owner()->associate($owner);
                $response->save();
            }
        }

        $sellers = \App\Models\User::role('Seller')->get();

        $survey  = Survey::first();

        foreach ($sellers as $seller) {
            $seller->surveyId = $survey->id;
            $seller->save();
        }

    }
}
