<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use Carbon\Carbon;

class SurveyAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $answers = [
            [
                'id'        => 1,
                'date' => Carbon::create(2022, 4, 8, 7, 30, 0),
            ],
            [
                'id'        => 2,
                'date' => Carbon::create(2022, 4, 8, 8, 30, 0),
            ],
            [
                'id'        => 3,
                'date' => Carbon::create(2022, 4, 8, 9, 30, 0),
            ],
        ];

        $survey = Survey::first();

        foreach ($answers as $answer) {
            if (!SurveyAnswer::where('id', $answer['id'])->first()) {
                $response = new SurveyAnswer;
                $response->date = $answer['date'];
                $response->survey()->associate($survey);
                $response->save();
            }
        }
    }
}
